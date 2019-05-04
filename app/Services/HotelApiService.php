<?php
namespace App\Services;
use App\User;
use App\Contracts\HotelApiServiceContract;
use DB;
use Auth;
use Session;
use Illuminate\Http\Response;
use App\Http\Requests;
use Mail;
use App\Banner;
use App\HotelStarCodes;
use App\HotelPriceMargin;
use App\Destinations;
use App\HotelBasicData;
use App\Settings;
use App\SmtpSetting;
use App\CurrencyCodes;
use App\RoomBasisCodes;
use App\CartData;
use App\CartItems;
use App\BookingGuests;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class HotelApiService implements HotelApiServiceContract
{
	public function hotel_search($req){
		if(!isset($req['cityVal'])){ $info['cityVal']  = $req['cityVal'] = ''; }	

		$info['room_count'] = $room_count = 1;
		$info['child_count'] = $child_count = 0;
		$info['adult_count'] = $adult_count = 1;
		$info['child_age'] = $child_age = array();
		if(isset($req['roomVal'])){ $info['room_count'] = $room_count = $req['roomVal'];}
		if(isset($req['adultVal'])){ $info['adult_count'] = $adult_count = $req['adultVal'];}
		if(isset($req['childrenVal'])){ $info['child_count'] = $child_count = $req['childrenVal'];}
		if(isset($req['child_age'])){ $info['child_age'] = $child_age = $req['child_age'];}
		$childDetail = "&childrenVal=0&child_age[]_1=0";
		$mych = $child_age;
		if($child_count>0){
			$childDetail  = "&childrenVal=$child_count";
			for($p=1;$p<=$child_count;$p++){
				for($o=0;$o<count($mych);$o++){
					$n = 1;
					$part1 = "&child_age[]_".$p."_".$n;
					$part2 = $mych[0];
					$childDetail .= $part1.'='.$part2;
					unset($mych[0]);
					break;
				}
				$mych = array_values($mych);
				continue;
			}
		}
		$rms = array();
		$main_array =array();
		$chs = array();
		$main_array2 =array();
		 if($adult_count>=$room_count){
			$it = ceil($adult_count/$room_count);
			for($x=1;$x<=$it;$x++){
				for($i=0;$i<$room_count;$i++){
					if($adult_count>0){
						$rms[$i][] = 1;
					}
					$adult_count--;
					
				}	
			}
			
			for($k=0;$k<count($rms);$k++){
				$main_array[] =count($rms[$k]); 
			}	
		}

		$chs = array();
		
		if($child_count>0){
			$cit = ceil($child_count/$room_count);
			for($y=1;$y<=$cit;$y++){
				for($j=0;$j<$room_count;$j++){
					if($child_count>0){
						$chs[$j][] = 1;
					}
					$child_count--;
				}	
			}
			for($l=0;$l<count($chs);$l++){
				$main_array2[] =count($chs[$l]); 
			}	
		}
		$rdata = array();
		for($b=0;$b<$room_count;$b++){
			if($main_array){
				$rdata[$b]['adults'] = $main_array[$b];
			}else{
				$rdata[$b]['adults'] = 0;
			}
			if($main_array2){
				if(isset($main_array2[$b])){
					$rdata[$b]['children'] = $main_array2[$b];
				}else{
					$rdata[$b]['children'] = 0;
				}
			}else{
				$rdata[$b]['children'] = 0;
			}
		}
 
		$info['CityCountry'] = '';
		$info['cityVal'] = $req['cityVal']; //required
		$fdate = date('m/d/Y', strtotime('+2 day', strtotime(date('m/d/Y')))); //+2 days of current date
		$tdate = date('m/d/Y', strtotime('+1 day', strtotime($fdate)));//+3 days of current date
		$book_date = $fdate.' - '.$tdate;
		$info['book_date']  = $book_date;
		$info['adultVal'] = $info['roomVal'] = $info['sortOrder'] = 1;
		$info['childrenVal']  = 0;
		$info['starsCode'] =  $info['starsOption'] = $stars_option = '';		
		$info['priceMin']  = 0;
		$info['priceMax']  = 10000;
		if(isset($req['priceMin'])){ $info['priceMin']  = $req['priceMin']; }		
		if(isset($req['priceMax'])){ $info['priceMax']  = $req['priceMax']; }
		$price_min_margin = $info['priceMin'];		
		$price_max_margin = $info['priceMax'];
		$price_margin_per = 0;
						 
/* 		$hpm_min = HotelPriceMargin::where('status',1)->selectRaw('min(margin_price_per) as margin_price_per')->first()->margin_price_per;				 		
		$hpm_max = HotelPriceMargin::where('status',1)->selectRaw('max(margin_price_per) as margin_price_per')->first()->margin_price_per;				 		

		
		 $price_min_margin = (($price_min_margin * $hpm_min)/100);
		$price_min_margin = round($price_min_margin,2);
		if($hpm_min > 0){
			//echo 'x';
			$price_min_margin = $info['priceMin'] - $price_min_margin;	
		}else{
			//echo 'y';
			$price_min_margin = $info['priceMin'] + $price_min_margin;
		}
		
		$price_max_margin = (($price_max_margin * $hpm_max)/100);
		$price_max_margin = round($price_max_margin,2);
		$price_max_margin = $info['priceMax'] - $price_max_margin;
		
	 	echo $price_min_margin.'<br>';
		echo $price_max_margin;
		die; */ 
/*  		if($info['starsCode']!=''){
			 $star_code_detail = HotelPriceMargin::where('starcode',$info['starsCode'])->first();
			 if($star_code_detail){
				$price_min_margin = (($price_min_margin * $star_code_detail->margin_price_per)/100);
				$price_min_margin = round($price_min_margin,2);
				$price_min_margin = $info['priceMin'] - $price_min_margin;	
				$price_max_margin = (($price_max_margin * $star_code_detail->margin_price_per)/100);
				$price_max_margin = round($price_max_margin,2);
				$price_max_margin = $info['priceMax'] - $price_max_margin;
				//$price_margin_per = $star_code_detail->margin_price_per;	//price margin by star code			
			 }
		}else{
			$setting_detail = Settings::where('key','site.hotel.defaultpricemargin')->first();
			 if($setting_detail){
				 $price_min_margin = (($price_min_margin * $setting_detail->value)/100);
				 $price_min_margin = round($price_min_margin,2);
				 $price_min_margin = $info['priceMin'] - $price_min_margin;	
				 $price_max_margin = (($price_max_margin * $setting_detail->value)/100);
				 $price_max_margin = round($price_max_margin,2);
				 $price_max_margin = $info['priceMax'] - $price_max_margin;	
				 //$price_margin_per = $setting_detail->value; // price margin default
			 }						
		}  */
					
		if(isset($req['book-date'])){ $info['book_date']  = $req['book-date']; }
		if(isset($req['adultVal'])){ $info['adultVal'] = $req['adultVal']; }
		if(isset($req['roomVal'])){ $info['roomVal'] = $req['roomVal']; }	
		if(isset($req['childrenVal'])){ $info['childrenVal'] = $req['childrenVal']; }	
		if(isset($req['sortOrder'])){ $info['sortOrder']  = $req['sortOrder']; }	
		if(isset($req['starsCode'])){
			$info['starsCode'] = $req['starsCode'];
			$info['starsOption']  = "<Stars>".$info['starsCode']."</Stars>";	
		}			
		
		$date = explode('-',$info['book_date']);
		$frdate = trim($date[0]);
		$info['ArrivalDate'] = $arrival_date = $frdate = date("Y-m-d", strtotime($frdate)); //required
		$todate = trim($date[1]);
		$todate = date("Y-m-d", strtotime($todate));
		$duration = strtotime($todate) - strtotime($frdate);
		$info['Nights'] = $nights_count = round($duration / (60 * 60 * 24)); //required
		$info['MaxResponses'] = 1000;	
		//$info['MaxResponses'] = 10;	
		$CityData = $this->get_cityData($info['cityVal']);
		$CityName = $CityData['city'];
		$CountryName = $this->get_countryName($CityData['countryID']);		
		$info['CityCountry'] = 	$CityName;
	//	echo '<pre>';print_r($info);die;
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>11</requestType>
		<xmlRequest><![CDATA[
		<Root>
		 <Header>
		  <Agency>86600</Agency>
		  <User>NYTXML</User>
		  <Password>nyT@#!2019</Password>
		  <Operation>HOTEL_SEARCH_REQUEST</Operation>
		  <OperationType>Request</OperationType>
		  <SearchGuid return="true"></SearchGuid>
		 </Header>
		 <Main Version="2.0" ResponseFormat="JSON" IncludeRating="true" Currency="USD"  MaxOffers="5" >
		  <SortOrder>'.$info["sortOrder"].'</SortOrder>
		  <FilterPriceMin>'.$price_min_margin.'</FilterPriceMin>
		  <FilterPriceMax>'.$price_max_margin.'</FilterPriceMax>
		  <MaximumWaitTime>5</MaximumWaitTime>
		  <MaxResponses>'.$info["MaxResponses"].'</MaxResponses>	  
		  <FilterRoomBasises>
		   <FilterRoomBasis></FilterRoomBasis>
		  </FilterRoomBasises>
		  <HotelName></HotelName>
		  <Apartments>false</Apartments>
		  <Nationality>US</Nationality>
		  <CityCode>'.$info["cityVal"].'</CityCode>
		  <ArrivalDate>'.$info["ArrivalDate"].'</ArrivalDate>
		  <Nights>'.$info["Nights"].'</Nights>'.$info["starsOption"].'
		  <Rooms>'; 
		if($rdata){
			$child_age_2 = $child_age;
			for($e=0;$e<count($rdata);$e++){
				$adultCount = $rdata[$e]['adults'];
				$childtCount = $rdata[$e]['children'];
				$input_xml .=   '<Room Adults="'.$adultCount.'" RoomCount="1">';
				
						if($childtCount > 0){
							for($c=0;$c<$childtCount;$c++){
							$input_xml .= '<ChildAge>'.$child_age_2[$c].'</ChildAge>';
								if(count($rdata)>1){
									unset($child_age_2[$c]);							
								}
							}
							$child_age_2 = array_values($child_age_2);
						}
				$input_xml .= '</Room>';
			}   
		}   
		$input_xml .='</Rooms>
		 </Main>
		</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$results = $this->hotel_api($input_xml); //XML Request
		
		//echo json_encode($results,true); die;
		$mydata = array();
		$total_price = $currency_value  = array();
		$currency = '$';
		$from_price = '';
		if($results){
			$hotels = $results['Hotels'];
			$response['info']['hotel_qty'] = $results['Header']['Stats']['HotelQty'];
			$response['info']['offer_qty'] = $results['Header']['Stats']['ResultsQty'];
			$i = 0;
			foreach($hotels as $row){
				$mydata[$i]['HotelName'] = $row['HotelName'];
				$mydata[$i]['HotelCode'] = $row['HotelCode'];
				$mydata[$i]['CountryId'] = $row['CountryId'];
				$mydata[$i]['CityId'] = $row['CityId'];
				$mydata[$i]['StarRating'] = '';
				$mydata[$i]['Thumbnail'] = env('APP_URL')."assets/img/hotel-default.png";
				if(isset($row['Thumbnail']) && $row['Thumbnail']!=''){
					//$file_headers = get_headers($row['Thumbnail']);
					//if($file_headers[0] == 'HTTP/1.1 200 OK'){
						$mydata[$i]['Thumbnail'] = $row['Thumbnail'];
					//} 	
				}
				if(isset($row['Location'])){
					$mydata[$i]['Location'] = $row['Location'];
				}else{
					$mydata[$i]['Location'] = '';
				}
				$mydata[$i]['Longitude'] = $row['Longitude'];
				$mydata[$i]['Rating'] = $row['Rating'];
				if(isset($row['RatingImage'])){
					$mydata[$i]['RatingImage'] = $row['RatingImage'];
				}else{
					$mydata[$i]['RatingImage'] = '';
				}
				$mydata[$i]['ReviewCount'] = $row['ReviewCount'];
				if(isset($row['Reviews'])){
					$mydata[$i]['Reviews'] = $row['Reviews'];
				}else{
					$mydata[$i]['Reviews'] = '';
				}			
				$mydata[$i]['Latitude'] = $row['Latitude'];
				$mydata[$i]['CityName'] = $CityName; 
				$mydata[$i]['CountryName'] =$CountryName;
				$mydata[$i]['HotelUrl'] = env('APP_URL')."hotel-detail?cityVal=".$info['cityVal']."&hotelVal=".$row['HotelCode']."&book-date=".$info['book_date']."&roomVal=".$info['roomVal']."&adultVal=".$info['adultVal'].$childDetail."&sortOrder=".$info['sortOrder']."&starsCode=".$info['starsCode'];
				$offer_data = $hotel_data = array();
					$RoomBasis = $rooms = $Remark = $Special = $HotelSearchCode = '';		
				if(count($row['Offers'])>0){
					$total_price = array();
					$currency_value = array();
					
					$x=0;
					$offer_data = $offers =  $row['Offers'];
					$m=0;
					foreach($offers as $offer){
						if($m == 0){
						$total_price[] = $offer['TotalPrice'];
						$currency_value[] = $offer['Currency'];
						$mydata[$i]['StarRating'] = $offer['Category'];
						$RoomBasis = $offer['RoomBasis'];
						$Remark = $offer['Remark'];
						$HotelSearchCode = $offer['HotelSearchCode'];
						if(isset($offer['Special'])){
						$Special = $offer['Special'];
						}
						$rooms = $offer['Rooms'][0];
						}
						$m++;
					}
					if($total_price){
						$from_price = min($total_price);
					}
					if($currency_value){
						$currency = strtoupper($currency_value[0]);
					}						
				}
				
				if($HotelSearchCode !=''){
				$hotel_data = $this->hotel_search_info($HotelSearchCode);
				}
				
				$mydata[$i]['HotelData'] = $hotel_data;
				$mydata[$i]['OffersCount'] = count($row['Offers']);
				$mydata[$i]['RoomBasis'] = $RoomBasis;
				$mydata[$i]['Rooms'] = $rooms;
				$mydata[$i]['Remark'] = $Remark;
				$mydata[$i]['Special'] = $Special;
				$mydata[$i]['OfferData'] = $offer_data;
				
				
				//$currency_detail = $this->get_currencyDetail(trim($currency));//should be remove
				$currency_id = 2; //USD
				//$currency_symbol = $currency_detail->symbol;						
				$currency_symbol = '$';						
				//$currency_code_name = $currency_detail->code;						
				$currency_code_name = 'USD';						
				
				if(isset($offer['Category']) && $offer['Category'] != ''){
					 $star_code_detail = HotelPriceMargin::where('starcode',$offer['Category'])->first();
					 if($star_code_detail){
						$price_margin_per = $star_code_detail->margin_price_per;	//price margin by star code			
					 }
				}
		
				if($price_margin_per != 0){
					$from_price = $from_price + (($from_price * $price_margin_per)/100);
					$from_price = round($from_price,2);
				}
				
				$mydata[$i]['PriceMarginPer'] = $price_margin_per;
				$mydata[$i]['FromPrice'] = $from_price;
				$mydata[$i]['Currency'] = $currency_symbol;
				$mydata[$i]['CurrencyCodeName'] = $currency_code_name;
				if($from_price >= $price_min_margin && $from_price < $price_max_margin){
					$i++;
				}else{
					unset($mydata[$i]);
				}
				
			}
			$response['data'] =  $mydata;
			return $response;
		}else{
			return $response;
		}		
	}
	
	public function hotel_detail($req){
		if(Auth::check()){ 
			$user_id = Auth::user()->id;
			$guest_user_id = 0;
			Session::put('guestUserId', $guest_user_id);
		}else{
			if(Session::get('guestUserId') !== 0){
				$user_id = 0;
				$guest_user_id = Session::get('guestUserId');
			}else{
				$user_id = 0;
				$guest_user_id = 0;
			}
		}
		
		if(!isset($req['cityVal'])){
			$info['cityVal'] = $req['cityVal'] = '';
		}
		if(!isset($req['hotelVal'])){
			$info['hotelVal'] = $req['hotelVal'] = '';
		}		

		$info['roomVal'] = $info['room_count'] = $room_count = 1;
		$info['childrenVal'] = $info['child_count'] = $child_count = 0;
		$info['adultVal'] = $info['adult_count'] = $adult_count = 1;
		$info['child_age'] = $child_age = array();
		$info['cityVal']  = $req['cityVal']; //required
		$info['hotelVal'] = $req['hotelVal']; //required
		$fdate = date('m/d/Y', strtotime('+2 day', strtotime(date('m/d/Y')))); //+2 days of current date
		$tdate = date('m/d/Y', strtotime('+1 day', strtotime($fdate)));//+3 days of current date
		$book_date = $fdate.' - '.$tdate;
		$info['book_date'] = $book_date;
		$info['sortOrder'] = 1;		
		$info['starsCode'] = $info['starsOption'] = '';	
		$info['priceMin']  = 0;
		$info['priceMax']  = 10000;		
		
		if(isset($req['roomVal'])){$info['roomVal'] = $info['room_count'] = $room_count = $req['roomVal'];}
		if(isset($req['adultVal'])){$info['adultVal'] = $info['adult_count'] = $adult_count = $req['adultVal'];}
		if(isset($req['childrenVal'])){$info['childrenVal'] = $info['child_count'] = $child_count = $req['childrenVal'];}
		if(isset($req['child_age'])){$info['child_age'] = $child_age = $req['child_age'];}
		if(isset($req['book-date'])){$book_date = $info['book_date'] = $req['book-date'];}
		if(isset($req['sortOrder'])){$info['sortOrder'] = $req['sortOrder'];}	
		if(isset($req['starsCode'])){
			$info['starsCode'] = $req['starsCode'];
			$info['starsOption'] = "<Stars>".$info['starsCode']."</Stars>";	
		}
		
		$date = explode('-',$info['book_date']);
		$frdate = trim($date[0]);
		$info['ArrivalDate'] = $frdate = date("Y-m-d", strtotime($frdate)); //required
		$todate = trim($date[1]);
		$todate = date("Y-m-d", strtotime($todate));
		$duration = strtotime($todate) - strtotime($frdate);
		$info['Nights']  = round($duration / (60 * 60 * 24)); //required
		$info['MaxResponses'] = $max_responses = 1000;
		if(isset($req['priceMin'])){ $info['priceMin']  = $req['priceMin']; }		
		if(isset($req['priceMax'])){ $info['priceMax']  = $req['priceMax']; }
		$price_min_margin = $info['priceMin'];		
		$price_max_margin = $info['priceMax'];		
		
		$childDetail = "&childrenVal=0&child_age[]_1=0";
		$mych = $child_age;
		if($child_count>0){
			$childDetail  = "&childrenVal=$child_count";
			for($p=1;$p<=$child_count;$p++){
				for($o=0;$o<count($mych);$o++){
					$n = 1;
					$part1 = "&child_age[]_".$p."_".$n;
					$part2 = $mych[0];
					$childDetail .= $part1.'='.$part2;
					unset($mych[0]);
					break;
				}
				$mych = array_values($mych);
				continue;
			}
		}
		
		$roomDetails= '';
		$rms = array();
		$main_array =array();
		$chs = array();
		$main_array2 =array();
		 if($adult_count>=$room_count){
			$it = ceil($adult_count/$room_count);
			for($x=1;$x<=$it;$x++){
				for($i=0;$i<$room_count;$i++){
					if($adult_count>0){
						$rms[$i][] = 1;
					}
					$adult_count--;
				}	
			}
			
			for($k=0;$k<count($rms);$k++){
				$main_array[] =count($rms[$k]); 
			}	
		}

		$chs = array();
		if($child_count>0){
			$cit = ceil($child_count/$room_count);
			for($y=1;$y<=$cit;$y++){
				for($j=0;$j<$room_count;$j++){
					if($child_count>0){
						$chs[$j][] = 1;
					}
					$child_count--;
				}	
			}
			
			for($l=0;$l<count($chs);$l++){
				$main_array2[] =count($chs[$l]); 
			}	
		}

		$rdata = array();
		for($b=0;$b<$room_count;$b++){
			if($main_array){
				$rdata[$b]['adults'] = $main_array[$b];
			}else{
				$rdata[$b]['adults'] = 0;
			}
			
			if($main_array2){
				if(isset($main_array2[$b])){
					$rdata[$b]['children'] = $main_array2[$b];
				}else{
					$rdata[$b]['children'] = 0;
				}
			}else{
				$rdata[$b]['children'] = 0;
			}
		}
		
		$rd_data = array();
		if($rdata){
			$child_age_e = $child_age;
			for($e=0;$e<count($rdata);$e++){
			$rd_data[$e]['adults'] = 	$adultCount = $rdata[$e]['adults'];
			$rd_data[$e]['children'] = 	$childtCount = $rdata[$e]['children'];
				if($childtCount > 0){
					for($c=0;$c<$childtCount;$c++){
					$rd_data[$e]['child_age'][$c] = $child_age_e[$c];
						if(count($rdata)>1){
							unset($child_age_e[$c]);							
						}
					}
					$child_age_e = array_values($child_age_e);
				}
			}   
		}
 		if($rd_data){
			$roomDetails = json_encode($rd_data,true);
		}

		if($info['starsCode']!=''){
			 $star_code_detail = HotelPriceMargin::where('starcode',$info['starsCode'])->first();
			 if($star_code_detail){
				$price_min_margin = (($price_min_margin * $star_code_detail->margin_price_per)/100);
				$price_min_margin = round($price_min_margin,2);
				$price_min_margin = $info['priceMin'] - $price_min_margin;	
				$price_max_margin = (($price_max_margin * $star_code_detail->margin_price_per)/100);
				$price_max_margin = round($price_max_margin,2);
				$price_max_margin = $info['priceMax'] - $price_max_margin;	
				$price_margin_per = $star_code_detail->margin_price_per;	//price margin by star code				
			 }
		}else{
			$setting_detail = Settings::where('key','site.hotel.defaultpricemargin')->first();
			if($setting_detail){
				$price_min_margin = (($price_min_margin * $setting_detail->value)/100);
				$price_min_margin = round($price_min_margin,2);
				$price_min_margin = $info['priceMin'] - $price_min_margin;	
				$price_max_margin = (($price_max_margin * $setting_detail->value)/100);
				$price_max_margin = round($price_max_margin,2);
				$price_max_margin = $info['priceMax'] - $price_max_margin;	
				$price_margin_per = $setting_detail->value; // price margin default				
			}						
		}	
		
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>11</requestType>
		<xmlRequest><![CDATA[
		<Root>
		 <Header>
		  <Agency>86600</Agency>
		  <User>NYTXML</User>
		  <Password>nyT@#!2019</Password>
		  <Operation>HOTEL_SEARCH_REQUEST</Operation>
		  <OperationType>Request</OperationType>
		  <SearchGuid return="true"></SearchGuid>
		 </Header>
		 <Main Version="2" ResponseFormat="JSON" IncludeRating="true" Currency="USD">
		  <SortOrder>'.$info["sortOrder"].'</SortOrder>
		  <FilterPriceMin>'.$price_min_margin.'</FilterPriceMin>
		  <FilterPriceMax>'.$price_max_margin.'</FilterPriceMax>
		  <MaximumWaitTime>5</MaximumWaitTime>
		  <MaxResponses>'.$info["MaxResponses"].'</MaxResponses>
		  <FilterRoomBasises>
		   <FilterRoomBasis></FilterRoomBasis>
		  </FilterRoomBasises>
		  <HotelName></HotelName>
		  <Apartments>false</Apartments>
		  <Nationality>US</Nationality>
		  <CityCode>'.$info["cityVal"].'</CityCode>
			<Hotels>
				<HotelId>'.$info["hotelVal"].'</HotelId>
			</Hotels>		  
		  <ArrivalDate>'.$info["ArrivalDate"].'</ArrivalDate>
		  <Nights>'.$info["Nights"].'</Nights>'.$info["starsOption"].'
		  <Rooms>'; 
		if($rdata){
			$child_age_2 = $child_age;
			for($e=0;$e<count($rdata);$e++){
				$adultCount = $rdata[$e]['adults'];
				$childtCount = $rdata[$e]['children'];
				$input_xml .=   '<Room Adults="'.$adultCount.'" RoomCount="1">';
				
						if($childtCount > 0){
							for($c=0;$c<$childtCount;$c++){
							$input_xml .= '<ChildAge>'.$child_age_2[$c].'</ChildAge>';
								if(count($rdata)>1){
									unset($child_age_2[$c]);							
								}
							}
							$child_age_2 = array_values($child_age_2);
						}
				$input_xml .= '</Room>';
			}   
		}   
		$input_xml .='</Rooms>
		 </Main>
		</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$results = $this->hotel_api($input_xml);
		echo '<pre>';print_R($results);die;
		//echo json_encode($results,true); die;	
			$mydata = array();
			$total_price = $currency_value  = array();
			$currency = '$';
			$from_price = '';
			if($results){
				$hotels = $results['Hotels'];
				$i = 0;
				$CityData = $this->get_cityData($info['cityVal']);
				$CityName = $CityData['city'];
				$CountryName = $this->get_countryName($CityData['countryID']);
				$price_margin_per=0;
				if($info['starsCode']!=''){
						 $star_code_detail = HotelPriceMargin::where('starcode',$info['starsCode'])->first();
						 if($star_code_detail){
							$price_margin_per = $star_code_detail->margin_price_per;
						 }
					}else{
						$setting_detail = Settings::where('key','site.hotel.defaultpricemargin')->first();
						 if($setting_detail){
							$price_margin_per = $setting_detail->value;
						 }						
					}
				foreach($hotels as $row){
					$mydata[$i]['HotelName'] = $row['HotelName'];
					$mydata[$i]['HotelCode'] = $row['HotelCode'];
					$mydata[$i]['CountryId'] = $row['CountryId'];
					$mydata[$i]['CityId'] = $row['CityId'];
					$mydata[$i]['Longitude'] = $row['Longitude'];
					$mydata[$i]['Latitude'] = $row['Latitude'];
					//$mydata[$i]['isBookAdded'] = 0;
/* 					if(Session::get('myCartId')){
						$cart_id = Session::get('myCartId');
						$cart_item_check = CartItems :: select(DB::raw("count(*) as count"))->where('cart_id',$cart_id)->first()->count;
						if($cart_item_check > 0){
							$mydata[$i]['isBookAdded'] = 1;
						}
					} */
					$mydata[$i]['Thumbnail'] = env('APP_URL')."assets/img/hotel-default.png";
					if(isset($row['Thumbnail']) AND $row['Thumbnail']!=''){
						$file_headers = get_headers($row['Thumbnail']);
						if($file_headers[0] == 'HTTP/1.1 200 OK'){
							$mydata[$i]['Thumbnail'] = $row['Thumbnail'];
						} 	
					}
					
					$mydata[$i]['SimilarHotels'] = $similar_hotels = array();
					$similar_hotels = HotelBasicData::where("cityid",$row['CityId'])->where("hotelid","!=",$row['HotelCode'])->orderByRaw("RAND()")->limit(5)->get();
					if($similar_hotels  && $similar_hotels->count() > 0){
						$h=0;
						foreach($similar_hotels as $shotel){
							$mydata[$i]['SimilarHotels'][$h]['hotel_id'] = $shotel->hotelid;
							$mydata[$i]['SimilarHotels'][$h]['hotel_name'] = $shotel->Name;
							$mydata[$i]['SimilarHotels'][$h]['city_id'] = $shotel->cityid;
							$mydata[$i]['SimilarHotels'][$h]['city_name'] = $shotel->city;
							$mydata[$i]['SimilarHotels'][$h]['country_id'] = $shotel->countryid;
							$mydata[$i]['SimilarHotels'][$h]['country_name'] = $shotel->country;		$mydata[$i]['SimilarHotels'][$h]['address'] = $shotel->Address;
							$mydata[$i]['SimilarHotels'][$h]['phone'] = $shotel->phone;
							$mydata[$i]['SimilarHotels'][$h]['fax'] = $shotel->fax;
	
							$hotel_detail_link = env('APP_URL')."hotel-detail?cityVal=".$shotel->cityid."&hotelVal=".$shotel->hotelid."&book-date=".$book_date."&roomVal=".$info['roomVal']."&adultVal=".$info['adultVal'].$childDetail."&sortOrder=".$info['sortOrder']."&starsCode=".$info['starsCode'];
							
							
							
							$mydata[$i]['SimilarHotels'][$h]['link'] = $hotel_detail_link;
							
							$mydata[$i]['SimilarHotels'][$h]['thumbnail'] = env('APP_URL')."assets/img/hotel-default.png";
							$img_link = 'https://cdn.goglobal.travel/HotelsV3/'.$shotel->hotelid.'/'.$shotel->hotelid.'_1t.jpg';	

							if($img_link!=''){
								$file_headers = array();
								$file_headers = get_headers($img_link);
								if($file_headers){
									if($file_headers[0] == 'HTTP/1.1 200 OK'){
										$mydata[$i]['SimilarHotels'][$h]['thumbnail'] = $img_link;
									} 	
								}
							}
							$h++;
						}
					}
					$mydata[$i]['StarRating'] = '';
					$mydata[$i]['Location'] = $row['Location'];
					$mydata[$i]['Longitude'] = $row['Longitude'];
					$mydata[$i]['Latitude'] = $row['Latitude'];
					$mydata[$i]['Rating'] = $row['Rating'];
					if(isset($row['RatingImage'])){
						$mydata[$i]['RatingImage'] = $row['RatingImage'];
					}else{
						$mydata[$i]['RatingImage'] = '';
					}				
					$mydata[$i]['ReviewCount'] = $row['ReviewCount'];
					if(isset($row['Reviews'])){
						$mydata[$i]['Reviews'] = $row['Reviews'];
					}else{
						$mydata[$i]['Reviews'] = '';
					}					
					$mydata[$i]['RoomDetails'] = $roomDetails;
					$mydata[$i]['CityName'] = $CityName;
					$mydata[$i]['CountryName'] = $CountryName;
					$mydata[$i]['Description'] = '';
					$mydata[$i]['HotelFacilities'] = array();
					
					$mydata[$i]['HotelUrl'] = env('APP_URL')."hotel-detail?cityVal=".$info['cityVal']."&hotelVal=".$row['HotelCode']."&book-date=".$info['book_date']."&roomVal=".$info['roomVal']."&adultVal=".$info['adultVal']."&childrenVal=".$info['childrenVal']."&sortOrder=".$info['sortOrder']."&starsCode=".$info['starsCode'];
								
					if(count($row['Offers'])>0){
						$total_price = array();
						$currency_value = array();						
						$x=0;
						$offers = $row['Offers'];
						foreach($offers as $offer){
							$total_price[] = $offer['TotalPrice'];
							$currency_value[] = $offer['Currency'];							
						}
					}
					if($total_price){
						$from_price = min($total_price);
					}
					if($currency_value){
						$currency = strtoupper($currency_value[0]);
					}
					
					$mydata[$i]['OffersCount'] = count($row['Offers']);
					$currency_detail = $this->get_currencyDetail(trim($currency));				
					$currency_id = 2;		//USD							
					$from_price = $this->convert_currency($currency_detail->id,$currency_id,$from_price);
					//$currency_detail2 = $this->get_currencyDetailById($currency_id); 
					//$currency_symbol = $currency_detail->symbol;						
					$currency_symbol = '$';						
					//$currency_code_name = $currency_detail->code;						
					$currency_code_name = 'USD';
					
					if(isset($offer['Category']) && $offer['Category'] != ''){
						 $star_code_detail = HotelPriceMargin::where('starcode',$offer['Category'])->first();
						 if($star_code_detail){
							$price_margin_per = $star_code_detail->margin_price_per;	//price margin by star code			
						 }
					}
			
					if($price_margin_per != 0){
						$from_price = $from_price + (($from_price * $price_margin_per)/100);
						$from_price = round($from_price,2);
					}
				
						
					$mydata[$i]['PriceMarginPer'] = $price_margin_per;
					$mydata[$i]['FromPrice'] = $from_price;
					$mydata[$i]['Currency'] = $currency_symbol;
					$mydata[$i]['CurrencyCodeName'] = $currency_code_name;
				
					$offers = $row['Offers'];
					$offers_data = array();
					$offer_code = array();
					$hotel_offer_code = $hotel_offer_no = '';
					$x = 0;
					$myhotelsearchcode= '';
					foreach($offers as $offer){
						$myhotelsearchcode = $offers_data[$x]['HotelSearchCode'] =  $offer['HotelSearchCode'];
						if($offer['HotelSearchCode']!=''){
							$offer_code = explode('/',$offer['HotelSearchCode']);
							if(count($offer_code) == '3'){
								$hotel_offer_code = $offer_code[0];
								$hotel_offer_no = $offer_code[2];
							}
						}
						$offers_data[$x]['HotelOfferCode'] =  $hotel_offer_code;
						$offers_data[$x]['HotelOfferNo'] =  $hotel_offer_no;
						$offers_data[$x]['isCartAdded'] = 0;						
						$offers_data[$x]['ArrivalDate'] = $info["ArrivalDate"];						
						$cart = CartData::where('user_id',$user_id)->where('guest_user_id',$guest_user_id)->where('is_completed',0)->orderBy('id','desc')->limit(1)->first();	
/* 						if($cart){ 
							$CartItemsCount = CartItems :: select(DB::raw("COUNT(*) AS offercount"))->where('cart_id',$cart->id)->where('hotel_code',$row['HotelCode'])->where('hotel_offer_code',$hotel_offer_code)->where('hotel_offer_no',$hotel_offer_no)->first()->offercount;
							if($CartItemsCount>0){
								$offers_data[$x]['isCartAdded'] = 1;
							}
						} */
						$offers_data[$x]['CxlDeadLine'] =  $offer['CxlDeadLine'];
						$offers_data[$x]['NonRef'] =  $offer['NonRef'];
						$offers_data[$x]['Rooms'] =  $offer['Rooms'];
						$room_basis_name = '';
						$room_basis_detail = RoomBasisCodes::where('code',trim($offer['RoomBasis']))->first();
						if($room_basis_detail){
							$room_basis_name = $room_basis_detail->description;
						}
						$offers_data[$x]['RoomBasis'] =  $offer['RoomBasis'];
						$offers_data[$x]['RoomBasisName'] = $room_basis_name;
						$offers_data[$x]['Availability'] =  $offer['Availability'];
						
						$acc_price = $offer['TotalPrice'];
						$offer_price = $offer['TotalPrice'];
						$offer_currency = $offer['Currency'];
						$offer_currency_code_name = trim($offer_currency);
						
						$offer_currency_detail = $this->get_currencyDetail($offer_currency_code_name);

						$offer_price = $this->convert_currency($offer_currency_detail->id,$currency_id,$offer_price);
						$offer_currency_detail2 = $this->get_currencyDetailById($currency_id); 
						$offer_currency_symbol = $offer_currency_detail2->symbol;						
						$offer_currency_code_name = $offer_currency_detail2->code;						

						if(isset($offer['Category']) && $offer['Category'] != ''){
							
							 $star_code_detail = HotelPriceMargin::where('starcode',$offer['Category'])->first();
							 if($star_code_detail){
								$price_margin_per = $star_code_detail->margin_price_per;	//price margin by star code			
							 }
						}
				
						if($price_margin_per != 0){
							$offer_price = $offer_price + (($offer_price * $price_margin_per)/100);
							$offer_price = round($offer_price,2);
						}
											
						$offers_data[$x]['TotalPrice'] =  $offer_price;
						$offers_data[$x]['AccPrice'] =  $acc_price;
						$offers_data[$x]['Currency'] =  $offer_currency_symbol;
						$offers_data[$x]['OfferCurrencyCodeName'] =  $offer_currency_code_name;
						$mydata[$i]['StarRating'] = $offers_data[$x]['Category'] =  $offer['Category'];
						$offers_data[$x]['Remark'] =  $offer['Remark'];
						if(isset($offer['Special'])){
							$offers_data[$x]['Special'] =  $offer['Special'];
						}else{
							$offers_data[$x]['Special'] =  '';
						}
						
						$offers_data[$x]['Preferred'] =  $offer['Preferred'];
						$x++;
					} 
					$mydata[$i]['Offers'] = $offers_data;
					$mydata[$i]['Gallery'] = array();
					
					if($myhotelsearchcode !=''){
						$hotel_info = array();
						$info2['HotelSearchCode'] = $myhotelsearchcode;
						$hotel_info = $this->hotel_info($info2);
						if($hotel_info){
							$hotel_info = (array)$hotel_info['data'];
							//echo $hotel_info['HotelSearchCode'].' ';
							if(isset($hotel_info['Pictures'])){
								$hotel_pictures = (array)$hotel_info['Pictures'];
								//echo '<pre>'; print_r($hotel_pictures); echo '</pre>';
								//$h=0;
								foreach($hotel_pictures as $picture=> $pic_val){
									$ppcc = (array)$pic_val;
									$pcount =  count($ppcc);
									for($h=0;$h<$pcount;$h++){
										if(isset($ppcc[$h])){
											$mydata[$i]['Gallery'][$h] = (string)$ppcc[$h];
										}
										
									}
								}
							}
							if(isset($hotel_info['Description'])){
								if($hotel_info['Description'] != ''){
									$mydata[$i]['Description'] = $hotel_info['Description'];
								}
							}
							if(isset($hotel_info['HotelFacilities'])){
								if($hotel_info['HotelFacilities'] != ''){
									$mydata[$i]['HotelFacilities'] = explode(',',$hotel_info['HotelFacilities']);
								}
							}							
						}
					} 
					$i++;
				}
			//die;
			//echo '<pre>';print_r($mydata);die;
			$response['data'] =  $mydata;
			return $response;
		}else{
			return $response;
		}
		
		}		
		
	public function booking_insert($req){
		$person_data = array();
		$children_data = array();
		$booking_rooms = array();
		$fdate = date('m/d/Y');
		$tdate = date('m/d/Y', strtotime('+1 day', strtotime($fdate)));
		$book_date = $fdate.' - '.$tdate;
		$info['book_date']  = $book_date;
		$info['adultVal'] = $info['roomVal'] = $info['sortOrder'] = 1;
		$info['childrenVal']  = 0;
		$info['hotel_search_code']  = 0;
		
					
		if(isset($req['book-date'])){ $info['book_date']  = $req['book-date']; }
		if(isset($req['adultVal'])){ $info['adultVal'] = $req['adultVal']; }
		if(isset($req['roomVal'])){ $info['roomVal'] = $req['roomVal']; }	
		if(isset($req['childrenVal'])){ $info['childrenVal'] = $req['childrenVal']; }	
		if(isset($req['booking_rooms'])){ $booking_rooms = $req['booking_rooms']; }		
		if(isset($req['hotel_search_code'])){ $info['hotel_search_code'] = $req['hotel_search_code']; }	
		//echo '<Pre>';print_r($person_data);die;
		
		$date = explode('-',$info['book_date']);
		$frdate = trim($date[0]);
		$info['ArrivalDate'] = $arrival_date = $frdate = date("Y-m-d", strtotime($frdate)); //required
		$todate = trim($date[1]);
		$todate = date("Y-m-d", strtotime($todate));
		$duration = strtotime($todate) - strtotime($frdate);
		$info['Nights'] = $nights_count = round($duration / (60 * 60 * 24)); //required
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>2</requestType>
		<xmlRequest><![CDATA[
			<Root>
				<Header>
					<Agency>86600</Agency>
					<User>NYTXML</User>
					<Password>nyT@#!2019</Password>
					<Operation>BOOKING_INSERT_REQUEST</Operation>
					<OperationType>Request</OperationType>
				</Header>
				<Main Version="2.0">
					<AgentReference>Test AgRef</AgentReference>
					<HotelSearchCode>'.$info["hotel_search_code"].'</HotelSearchCode>
					<ArrivalDate>'.$info["ArrivalDate"].'</ArrivalDate>
					<Nights>'.$info["Nights"].'</Nights>
					<NoAlternativeHotel>1</NoAlternativeHotel>
					<Leader LeaderPersonID="1"/>		
					<Rooms>';
			if($booking_rooms && $booking_rooms->count() >0){
				foreach($booking_rooms as $br){
					$b_total_guests = $br->total_guests;
					$b_adult_count = $br->adult_count;
					$b_child_count = $br->child_count;
					$input_xml .=	'<RoomType Adults="'.$b_adult_count.'" >
										<Room RoomID="1">';					
					$booking_guests = BookingGuests::where('booking_room_id',$br->id)->get();
					if($booking_guests && $booking_guests->count() >0){
						foreach($booking_guests as $bg){
							if($bg->is_child !=1){
								$input_xml .= '<PersonName PersonID="'.$bg->person_id.'" Title="'.$bg->title.'" FirstName="'.strtoupper($bg->first_name).'" LastName="'.strtoupper($bg->last_name).'" />';	
							}else{
								$input_xml .= '<ExtraBed PersonID="'.$bg->person_id.'" FirstName="'.strtoupper($bg->first_name).'" LastName="'.strtoupper($bg->last_name).'" ChildAge="'.$bg->child_age.'" />';	
							}
						}
					}
					$input_xml .=  '  </Room>
									</RoomType>';
				}
			}
		$input_xml .='</Rooms>
				</Main>
			</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->booking_api($input_xml); //XML Request
		//echo json_encode($results,true); die;
		if($results){
			$response['data'] = $results;
			$response['info']['error'] = 0;
		}
		if($response['info']['error'] == 0){
			return $response;
		}else{
			return false;
		}
	}


	public function price_breakdown($req){

		$info['HotelSearchCode']  = '';		
		$info['stars']  = '';		
		if(isset($req['HotelSearchCode'])){ $info['HotelSearchCode']  = $req['HotelSearchCode']; }
		if(isset($req['stars'])){ $info['stars']  = $req['stars']; }

		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>14</requestType>
		<xmlRequest><![CDATA[
			<Root>
				<Header>
					<Agency>86600</Agency>
					<User>NYTXML</User>
					<Password>nyT@#!2019</Password>
					<Operation>PRICE_BREAKDOWN_REQUEST</Operation>
					<OperationType>Request</OperationType>
				</Header>
				<Main>
					<HotelSearchCode>'.$info["HotelSearchCode"].'</HotelSearchCode>
				</Main>
			</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->my_api($input_xml); //XML Request
		//echo '<Pre>';print_r($results);die;
		
		$mydata = array();
		if($results){
			$room_data = $results['Room'];
			if(is_array($room_data)){
				$x=0;
				foreach($room_data as $room){
					$room = (array)$room;
					$mydata[$x]['RoomCount'] = $x+1;
					if(is_array($room['PriceBreakdown'])){
						//multiple rooms vs multiple nights
						$price_breakdown_array = $room['PriceBreakdown'];
						$y=0;
						foreach($price_breakdown_array as $pb_data){
							$pb_data = (array)$pb_data;
							$pb_currency = $pb_data['Currency']; 
							$currency_detail = $this->get_currencyDetail(trim($pb_currency));
							$currency_id = 2; //USD
							$from_price = $pb_data['Price'];
							$currency_symbol = $currency_detail->symbol;						
							$currency_code_name = $currency_detail->code;						
							$price_margin_per = 0;
							
							if(isset($info['stars']) && $info['stars'] != ''){
								 $star_code_detail = HotelPriceMargin::where('starcode',$info['stars'])->first();
								 if($star_code_detail){
									$price_margin_per = $star_code_detail->margin_price_per;	//price margin by star code			
								 }
							}else{
								$setting_detail = Settings::where('key','site.hotel.defaultpricemargin')->first();
								 if($setting_detail){
									 $from_price = $from_price + (($from_price * $setting_detail->value)/100);
									 $from_price = round($from_price,2);
									 $price_margin_per = $setting_detail->value;
								 }						
							}
							
							if($price_margin_per != 0){
								$from_price = $from_price + (($from_price * $price_margin_per)/100);
								$from_price = round($from_price,2);
							}
				
							//echo $from_price;die('rk1');
							$mydata[$x]['PriceBreakdown'][$y]['Price'] = $from_price;
							$mydata[$x]['PriceBreakdown'][$y]['Currency'] = $currency_symbol;
							$mydata[$x]['PriceBreakdown'][$y]['FromDate'] = date('m/d/Y',strtotime($pb_data['FromDate']));	
							$mydata[$x]['PriceBreakdown'][$y]['ToDate'] = date('m/d/Y',strtotime($pb_data['ToDate']));	
							$y++;
						}
						//die('price break is array');
					}else{
						//multiple rooms vs single night
						$pb_data = (array)$room['PriceBreakdown'];
						//echo '<pre>';print_r($pb_data);
							$pb_currency = $pb_data['Currency']; 
							$currency_detail = $this->get_currencyDetail(trim($pb_currency));
							$currency_id = 2; //USD
							$from_price = $pb_data['Price'];
							$currency_symbol = $currency_detail->symbol;					
							$currency_code_name = $currency_detail->code;
							$price_margin_per = 0;
							if(isset($info['stars']) && $info['stars'] != ''){
								 $star_code_detail = HotelPriceMargin::where('starcode',$info['stars'])->first();
								 if($star_code_detail){
									$price_margin_per = $star_code_detail->margin_price_per;	//price margin by star code			
								 }
							}else{
								$setting_detail = Settings::where('key','site.hotel.defaultpricemargin')->first();
								 if($setting_detail){
									 $from_price = $from_price + (($from_price * $setting_detail->value)/100);
									 $from_price = round($from_price,2);
									 $price_margin_per = $setting_detail->value;
								 }						
							}
							
							if($price_margin_per != 0){
								$from_price = $from_price + (($from_price * $price_margin_per)/100);
								$from_price = round($from_price,2);
							}
							//echo $from_price;die('rk2');
							$mydata[$x]['PriceBreakdown'][0]['Price'] = $from_price;
							$mydata[$x]['PriceBreakdown'][0]['Currency'] = $currency_symbol;
							$mydata[$x]['PriceBreakdown'][0]['FromDate'] = date('m/d/Y',strtotime($pb_data['FromDate']));	
							$mydata[$x]['PriceBreakdown'][0]['ToDate'] = date('m/d/Y',strtotime($pb_data['ToDate']));								
					}
					//$price_breakdown_array = (array)$room['PriceBreakdown'];
					//echo $price_breakdown_array['Currency'];
				 $x++;	
				}
				//die('p array');
			}else{
				//single room vs multiple nights
				$room_data = (array)$room_data;
				$mydata[0]['RoomCount'] = 1;
				
				if(is_array($room_data['PriceBreakdown'])){
						$price_breakdown_array = $room_data['PriceBreakdown'];
						
						$y=0;
						foreach($price_breakdown_array as $pb_data){
							
							$pb_data = (array)$pb_data;
							$pb_currency = $pb_data['Currency']; 
							$currency_detail = $this->get_currencyDetail(trim($pb_currency));
							$currency_id = 2; //USD
							$from_price = $pb_data['Price'];
							$currency_symbol = $currency_detail->symbol;					
							$currency_code_name = $currency_detail->code;
							$price_margin_per = 0;
							
							if(isset($info['stars']) && $info['stars'] != ''){
								 $star_code_detail = HotelPriceMargin::where('starcode',$info['stars'])->first();
								 if($star_code_detail){
									$price_margin_per = $star_code_detail->margin_price_per;	//price margin by star code			
								 }
							}else{
								$setting_detail = Settings::where('key','site.hotel.defaultpricemargin')->first();
								 if($setting_detail){
									 $from_price = $from_price + (($from_price * $setting_detail->value)/100);
									 $from_price = round($from_price,2);
									 $price_margin_per = $setting_detail->value;
								 }						
							}
							
							if($price_margin_per != 0){
								$from_price = $from_price + (($from_price * $price_margin_per)/100);
								$from_price = round($from_price,2);
							}
							//echo $from_price;die('rk3');
							$mydata[0]['PriceBreakdown'][$y]['Price'] = $from_price;
							$mydata[0]['PriceBreakdown'][$y]['Currency'] = $currency_symbol;
							$mydata[0]['PriceBreakdown'][$y]['FromDate'] = date('m/d/Y',strtotime($pb_data['FromDate']));	
							$mydata[0]['PriceBreakdown'][$y]['ToDate'] = date('m/d/Y',strtotime($pb_data['ToDate']));	
						$y++;	
						}
						//die('price break is array');					
				}else{
					//single room vs single night
						$pb_data = (array)$room_data['PriceBreakdown'];
						//echo '<pre>';print_r($room_data);die;
							$pb_currency = $pb_data['Currency']; 
							$currency_detail = $this->get_currencyDetail(trim($pb_currency));
							$currency_id = 2; //USD
							$from_price = $pb_data['Price'];
							$currency_symbol = $currency_detail->symbol;						
							$currency_code_name = $currency_detail->code;						
							
							$price_margin_per = 0;
							if(isset($info['stars']) && $info['stars'] != ''){
								 $star_code_detail = HotelPriceMargin::where('starcode',$info['stars'])->first();
								 if($star_code_detail){
									$price_margin_per = $star_code_detail->margin_price_per;	//price margin by star code			
								 }
							}else{
								$setting_detail = Settings::where('key','site.hotel.defaultpricemargin')->first();
								 if($setting_detail){
									 $from_price = $from_price + (($from_price * $setting_detail->value)/100);
									 $from_price = round($from_price,2);
									 $price_margin_per = $setting_detail->value;
								 }						
							}
							
							if($price_margin_per != 0){
								$from_price = $from_price + (($from_price * $price_margin_per)/100);
								$from_price = round($from_price,2);
							}
							//echo $from_price;die('rk4');
							$mydata[0]['PriceBreakdown'][0]['Price'] = $from_price;
							$mydata[0]['PriceBreakdown'][0]['Currency'] = $currency_symbol;
							$mydata[0]['PriceBreakdown'][0]['FromDate'] = date('m/d/Y',strtotime($pb_data['FromDate']));	
							$mydata[0]['PriceBreakdown'][0]['ToDate'] = date('m/d/Y',strtotime($pb_data['ToDate']));					
				}
			}
			$response['data'] = $mydata;
			$response['info']['error'] = 0;
		}
		//echo '<pre>';print_R($mydata);die('mydata');
		if($response['info']['error'] == 0){
			return $response;
		}else{
			return false;
		}
	}

	public function hotel_info($req){

		$info['HotelSearchCode']  = '';		
		if(isset($req['HotelSearchCode'])){ $info['HotelSearchCode']  = $req['HotelSearchCode']; }
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>6</requestType>
		<xmlRequest><![CDATA[
			<Root>
				<Header>
					<Agency>86600</Agency>
					<User>NYTXML</User>
					<Password>nyT@#!2019</Password>
					<Operation>HOTEL_INFO_REQUEST</Operation>
					<OperationType>Request</OperationType>
				</Header>
				<Main>
					<HotelSearchCode>'.$info["HotelSearchCode"].'</HotelSearchCode>
				</Main>
			</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->my_api($input_xml); //XML Request
		//echo json_encode($results,true); die;
		//echo '<Pre>';print_r($results);die;
		if($results){
			$response['data'] = $results;
			$response['info']['error'] = 0;
		}
		if($response['info']['error'] == 0){
			return $response;
		}else{
			return false;
		}
		
	}
	
	public function hotel_search_info($HotelSearchCode){
    
		$info['HotelSearchCode']  = '';		
		if($HotelSearchCode !=''){ $info['HotelSearchCode']  = $HotelSearchCode; }
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>6</requestType>
		<xmlRequest><![CDATA[
			<Root>
				<Header>
					<Agency>86600</Agency>
					<User>NYTXML</User>
					<Password>nyT@#!2019</Password>
					<Operation>HOTEL_INFO_REQUEST</Operation>
					<OperationType>Request</OperationType>
				</Header>
				<Main>
					<HotelSearchCode>'.$info["HotelSearchCode"].'</HotelSearchCode>
				</Main>
			</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->my_api($input_xml); //XML Request
		//echo json_encode($results,true); die;
		//echo '<Pre>';print_r($results);die;
		if($results){
			$response['data'] = $results;
			$response['info']['error'] = 0;
		}
		if($response['info']['error'] == 0){
			return $response;
		}else{
			return false;
		}
		
	}
	
	public function booking_valuation($req){

		$info['HotelSearchCode']  = '';		
		$info['ArrivalDate']  = '';		
		if(isset($req['HotelSearchCode'])){ $info['HotelSearchCode']  = $req['HotelSearchCode']; }
		if(isset($req['ArrivalDate'])){ $info['ArrivalDate']  = $req['ArrivalDate']; }
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>9</requestType>
		<xmlRequest><![CDATA[
			<Root>
				<Header>
					<Agency>86600</Agency>
					<User>NYTXML</User>
					<Password>nyT@#!2019</Password>
					<Operation>BOOKING_VALUATION_REQUEST</Operation>
					<OperationType>Request</OperationType>
				</Header>
				<Main Version="2.0">
					<HotelSearchCode>'.$info["HotelSearchCode"].'</HotelSearchCode>
					<ArrivalDate>'.$info["ArrivalDate"].'</ArrivalDate>
				</Main>
			</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->my_api($input_xml); //XML Request
		//echo json_encode($results,true); die;
		if($results){
			$response['data'] = $results;
			$response['info']['error'] = 0;
		}
		if($response['info']['error'] == 0){
			return $response;
		}else{
			return false;
		}
		
	}
	
	public function cancel_booking($req){

		$info['GoBookingCode']  = '';		

		if(isset($req['GoBookingCode'])){ $info['GoBookingCode']  = $req['GoBookingCode']; }
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>3</requestType>
		<xmlRequest><![CDATA[
			<Root>
				<Header>
					<Agency>86600</Agency>
					<User>NYTXML</User>
					<Password>nyT@#!2019</Password>
					<Operation>BOOKING_CANCEL_REQUEST</Operation>
					<OperationType>Request</OperationType>
				</Header>
				<Main>
					<GoBookingCode>'.$info["GoBookingCode"].'</GoBookingCode>
				</Main>
			</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->my_api($input_xml); //XML Request
		//echo json_encode($results,true); die;
		if($results){
			$response['data'] = $results;
			$response['info']['error'] = 0;
		}
		if($response['info']['error'] == 0){
			return $response;
		}else{
			return false;
		}
		
	}
	
	public function booking_status($req){

		$info['booking_code']  = '';		
		if(isset($req['booking_code'])){ $info['booking_code']  = $req['booking_code']; }
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>5</requestType>
		<xmlRequest><![CDATA[
			<Root>
				<Header>
					<Agency>86600</Agency>
					<User>NYTXML</User>
					<Password>nyT@#!2019</Password>
					<Operation>BOOKING_STATUS_REQUEST</Operation>
					<OperationType>Request</OperationType>
				</Header>
					<Main>
						<GoBookingCode>'.$info["booking_code"].'</GoBookingCode>
					</Main>
			</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->booking_api($input_xml); //XML Request
		//echo json_encode($results,true); die;
		if($results){
			$response['data'] = $results;
			$response['info']['error'] = 0;
		}
		if($response['info']['error'] == 0){
			return $response;
		}else{
			return false;
		}
		
	}
	
	public function voucher_detail($req){

		$info['booking_code']  = '';		
		if(isset($req['booking_code'])){ $info['booking_code']  = $req['booking_code']; }
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>8</requestType>
		<xmlRequest><![CDATA[
			<Root>
				<Header>
					<Agency>86600</Agency>
					<User>NYTXML</User>
					<Password>nyT@#!2019</Password>
					<Operation>VOUCHER_DETAILS_REQUEST</Operation>
					<OperationType>Request</OperationType>
				</Header>
					<Main>
						<GoBookingCode>'.$info["booking_code"].'</GoBookingCode>
						<GetEmergencyPhone>true</GetEmergencyPhone>
					</Main>
			</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->booking_api($input_xml); //XML Request
		//echo json_encode($results,true); die;
		if($results){
			$response['data'] = $results;
			$response['info']['error'] = 0;
		}
		if($response['info']['error'] == 0){
			return $response;
		}else{
			return false;
		}
		
	}
	
	public function hotel_api($input_xml){
		
		$results = array();
		$header = array(
			"Content-type: application/soap+xml;charset=utf-8"
		);
		  
		$url = "https://nytstay.xml.goglobal.travel/xmlwebservice.asmx";
		$soap_do = curl_init();
		curl_setopt($soap_do, CURLOPT_URL,$url);
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        30);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($soap_do, CURLOPT_POST,           true );
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $input_xml);
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);
		 
		if(curl_exec($soap_do) === false){
			$err = 'Curl error: ' . curl_error($soap_do);
			curl_close($soap_do);
			//return $err;
			return false;
		}else{
			$response = curl_exec($soap_do); 
			
			//echo '<pre>';print_r($response);die;
			curl_close($soap_do);
			$pos1 = strpos($response,"<MakeRequestResult>");
			$pos2 = strpos($response,"</MakeRequestResult>");
			$resp = substr($response, $pos1 + strlen("<MakeRequestResult>"), $pos2 - ($pos1 + strlen("<MakeRequestResult>")) );
			$results = json_decode($resp,true);					
			return $results;
		}
	}

	public function my_api($input_xml){
		$results = array();
		$header = array(
			"Content-type: application/soap+xml;charset=utf-8"
		);
		  
		$url = "https://nytstay.xml.goglobal.travel/xmlwebservice.asmx";
		$soap_do = curl_init();
		curl_setopt($soap_do, CURLOPT_URL,$url);
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        30);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($soap_do, CURLOPT_POST,           true );
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $input_xml);
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);
		 
		if(curl_exec($soap_do) === false){
			$err = 'Curl error: ' . curl_error($soap_do);
			curl_close($soap_do);
			//return $err;
			return false;
		}else{
			$response = curl_exec($soap_do); 
			//header('Content-Type: application/xhtml+xml');
			//echo $response;die;			
		//	echo '<pre>';print_r($response);die;
			//echo $response;die;
			curl_close($soap_do);
 			$pos1 = strpos($response,"<MakeRequestResult>");
			$pos2 = strpos($response,"</MakeRequestResult>");
			$resp = substr($response, $pos1 + strlen("<MakeRequestResult>"), $pos2 - ($pos1 + strlen("<MakeRequestResult>")) ); 
			
			$ob= simplexml_load_string(html_entity_decode($resp));	

			$results = (array) $ob;
			//echo json_encode($results,true); die;
			if(isset($results['Main'])){
				$results = (array) $results['Main'];
				if(isset($results['Error'])){
					return false;
				}else{
					return $results;
				}				
			}else{
				return false;
			}
		}
	}
	
	public function booking_api($input_xml){
		$results = array();
		$header = array(
			"Content-type: application/soap+xml;charset=utf-8"
		);
		  
		$url = "https://nytstay.xml.goglobal.travel/xmlwebservice.asmx";
		$soap_do = curl_init();
		curl_setopt($soap_do, CURLOPT_URL,$url);
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        30);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($soap_do, CURLOPT_POST,           true );
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $input_xml);
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);
		 
		if(curl_exec($soap_do) === false){
			$err = 'Curl error: ' . curl_error($soap_do);
			curl_close($soap_do);
			//return $err;
			return false;
		}else{
			$response = curl_exec($soap_do); 
			//header('Content-Type: application/xhtml+xml');
			//echo $response;die;
			//echo '<pre>';print_r($response);die;
			
			curl_close($soap_do);
			$pos1 = strpos($response,"<MakeRequestResult>");
			$pos2 = strpos($response,"</MakeRequestResult>");
			$resp = substr($response, $pos1 + strlen("<MakeRequestResult>"), $pos2 - ($pos1 + strlen("<MakeRequestResult>")) );
				
			$ob= simplexml_load_string(html_entity_decode($resp));	
			//echo json_encode($ob,true); die;
			$booking_data = array();
			if(isset($ob->Main->GoBookingCode)){
				$arr = (array) $ob->Main->GoBookingCode->attributes();
				foreach( $arr as $a){
				  $booking_data = $a;
				}				
			}
			$results = (array) $ob;
			//echo json_encode($results,true); die;
			$results = (array) $results['Main'];
			$results['booking_data'] = $booking_data;
			if(isset($results['Error'])){
				return false;
			}else{
				return $results;
			}		
			
		}
	}

	public function get_cityData($cityId){
		if ($cityId!=''){
	
			$city = Destinations::select(DB::raw("*"))->where('cityID',$cityId)->first();
			if($city){
				return $city;
			}else{
				return false;
			}
		}
    }
	
    public function get_cityName($cityId){
		if ($cityId!=''){
	
			$city = Destinations::select(DB::raw("*"))->where('cityID',$cityId)->first();
			if($city){
				return $city->city;
			}else{
				return false;
			}
		}
    }	
	
    public function get_countryName($countryId){
		if ($countryId!=''){
	
			$country = Destinations::select(DB::raw("*"))->where('countryID',$countryId)->first();
			if($country){
				return $country->country;
			}else{
				return false;
			}
		}
    }	

	
    public function get_currencyDetail($currencyCode){
		if ($currencyCode!=''){
	
			$currency = CurrencyCodes::select(DB::raw("*"))->where('code',$currencyCode)->first();
			if($currency){
				return $currency;
			}else{
				return false;
			}
		}
    }	
		

    public function get_currencyDetailById($currencyId){
		if ($currencyId!=''){
	
			$currency = CurrencyCodes::select(DB::raw("*"))->where('id',$currencyId)->first();
			if($currency){
				return $currency;
			}else{
				return false;
			}
		}
    }
	
	public function convert_currency($from_currency,$to_currency,$amount){ 

		$final_amount = 0.00;
		$base_currency = '2'; //USD
		
 		$from_data = CurrencyCodes::where('id', $from_currency)->first();
		
		$to_data = CurrencyCodes::where('id', $to_currency)->first();
		
		
		//get from currency table
		if($from_currency == '2'){
			$from_currency_usd_rate = 1; 
		}else{

			$from_currency_usd_rate = $from_data->usd_price_rate; 
		}

		if($to_currency == '2'){
			$to_currency_usd_rate = 1; 

		}else{

			$to_currency_usd_rate = $to_data->usd_price_rate; 
		}
		
		//conversion calculation

			$from_c_amount_in_usd = $amount * $from_currency_usd_rate;
			
			if($to_currency_usd_rate != 0){
				$final_amount = $from_c_amount_in_usd / $to_currency_usd_rate;

					$final_amount =  round($final_amount,2);	
					//$final_amount =  number_format($final_amount,0);	
								
			}else{
				$final_amount = 0;
				//$final_amount =  number_format($final_amount,0);			
		}
		return $final_amount;
		
	}	
 
 	public function send_email($info,$file,$attachment='') { 
	
	//return true;
			$msg_body = view($file,['info'=>$info])->render();
			$subject = $info['subject'];
			$setting = SmtpSetting::where('id',1)->first();
			$user_smtp =$setting->toArray();
		 	$from=$user_smtp['from_email'];
		    $from_name=$user_smtp['from_name'];
		    $smtp_username=$user_smtp['smtp_username'];
		    $smtp_password=$user_smtp['smtp_password'];
		    $smtp_authentication=$user_smtp['smtp_authentication'] == 'Yes'?'True':'False';
		    $smtp_security=$user_smtp['smtp_security'];
		    $port=$user_smtp['smtp_port'];
		    $host=$user_smtp['smtp_host'];
		    $email = $info['email'];
		  //  $email = 'malakar.neeraj@gmail.com';
		   //$email = 'ravikmalisws@gmail.com';
		    $fname = $info['name'];
           
			//echo $message;die;
		   $mail = new PHPMailer(true);   
		   try {
			  //$mail->CharSet = 'UTF-8';
			  $mail->isSMTP();   
			  $mail->Host ="$host";  
			  $mail->SMTPAuth =$smtp_authentication;                              
			  $mail->Username ="$smtp_username";                
			  $mail->Password = "$smtp_password";                           
			  $mail->SMTPSecure ="$smtp_security";                          
			  $mail->Port = $port;                                
			  $mail->setFrom("$from","$from_name");
			  $mail->addAddress("$email","$fname");     
			  $mail->addReplyTo("$from","$from_name");
			  if($attachment != ''){
			  $mail->AddAttachment($attachment, '', $encoding = 'base64', $type = 'application/pdf');
			  }
			  $mail->isHTML(true);                                 
			  $mail->Subject = $subject;
			  $mail->Body    = $msg_body;
			  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
			  
			  if(!$mail->Send()) { 
			   // echo 'no';die;
			  }else{ 
			   //echo 'yes';die;
			  } 
			} catch (Exception $e) {
			 //echo 'Message: ' .$e->getMessage();die;
			}
			//echo 'success';die;
			return true;
    }
	
	public function get_hotel_cities($req){
		if($req['search_value']!=''){
			$search_value = $req['search_value'];
			$destinations = Destinations::orWhere('city', 'like', $search_value. '%')->orWhere('country', 'like', $search_value. '%')->orderBy('city','asc')->get();
		}else{
			$destinations = Destinations::orderBy('city','asc')->get();
		}
		if($destinations->count()>0){
				return view('hotel.get_cities',['destinations'=>$destinations])->render();
					
		}else{
			return 0;
		}		
		
	}
	
	public function get_travel_places($req){
		$get_travel_places = array();
		if($req['search_value']!=''){
			$search_value = $req['search_value'];
		
		$airport = DB::table('airport_codes')->select(DB::raw("'airport' as type, airport_codes.DestinationCode as code ,airport_codes.DestinationName as name ,airport_codes.City as location,airport_codes.cityID as city_id"))->where('airport_codes.DestinationName', 'like', $search_value. '%');
		
		$hotel = DB::table('hotel_basic_data')->select(DB::raw("'hotel' as type, hotel_basic_data.hotelid as code ,hotel_basic_data.Name as name,hotel_basic_data.city as location,hotel_basic_data.cityid as city_id"))->where('hotel_basic_data.Name', 'like', $search_value. '%');
			
		$get_travel_places = DB::table('destinations')
					->select(DB::raw("'city' as type, destinations.cityID as code ,destinations.city as name,destinations.country as location,destinations.cityID as city_id"))
					->where('destinations.city', 'like', $search_value. '%')
					->union($airport)
					->union($hotel)
					->get();				
		}

		if($get_travel_places && $get_travel_places->count()>0){
			return view('travel.get_travel_places',['get_travel_places'=>$get_travel_places])->render();
		}else{
			return 0;
		}		
		
	}	

/*********************************************** TRAVEL PART **************************************/	
	public function travel_search($req){
		if(Auth::check()){ 
			$user_id = Auth::user()->id;
			$guest_user_id = 0;
			Session::put('guestUserId', $guest_user_id);
		}else{
			if(Session::get('guestUserId') !== 0){
				$user_id = 0;
				$guest_user_id = Session::get('guestUserId');
			}else{
				$user_id = 0;
				$guest_user_id = 0;
			}
		}
		
		$pickup_type = $info["pickup_type"] = '';
		$info["pickup_code"] = '';
		$dropoff_type = $info["dropoff_type"] = '';
		$info["dropoff_code"] = '';
		$info["pickup_acc"] = '';
		$info["arriving_city_id"] = '';
		$info["dropoff_acc"] = '';
		$info["departing_city_id"] = '';
		$info["travel_book_date"] = '';
		$travel_book_date = date('Y-m-d');
		$info["passangers_count"] = 1;
		$info["pickupPlaceName"] = '';
		$info["dropoffPlaceName"] = '';

		if(isset($req['pickupTypeVal'])){ 
			$info['pickup_type']  = $req['pickupTypeVal']; 
			if($info['pickup_type'] == 'airport'){
				$pickup_type = 'Airport';
			}else{
				$pickup_type = 'Accommodation';
			}
		}
		if(isset($req['pickupCodeVal'])){ 
			$info['pickup_code']  = $req['pickupCodeVal']; 
		}
		if(isset($req['dropoffTypeVal'])){ 
			$info['dropoff_type']  = $req['dropoffTypeVal']; 
			if($info['dropoff_type'] == 'airport'){
				$dropoff_type = 'Airport';
			}else{
				$dropoff_type = 'Accommodation';
			}			
		}
		if(isset($req['dropoffCodeVal'])){ 
			$info['dropoff_code']  = $req['dropoffCodeVal']; 
		}
		if(isset($req['passangerVal'])){
			$info['passangers_count']  = $req['passangerVal'];
		}
		if(isset($req['travel_book_date'])){ 
			$info['travel_book_date'] = $req['travel_book_date'];
			$travel_book_date  = date('Y-m-d',strtotime($req['travel_book_date']));
		}
		if(isset($req['pickupPlaceName'])){
			$info['pickupPlaceName']  = $req['pickupPlaceName'];
		}
		if(isset($req['dropoffPlaceName'])){
			$info['dropoffPlaceName']  = $req['dropoffPlaceName'];
		}	
		if(isset($req['pickupAcc'])){
			$info['pickup_acc']  = $req['pickupAcc'];
		}	
		if(isset($req['acityidVal'])){
			$info['arriving_city_id']  = $req['acityidVal'];
		}		
		if(isset($req['dropoffAcc'])){
			$info['dropoff_acc']  = $req['dropoffAcc'];
		}	
		if(isset($req['dcityidVal'])){
			$info['departing_city_id']  = $req['dcityidVal'];
		}			
		
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '';
		$input_xml .= '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>17</requestType>
		<xmlRequest><![CDATA[
					<Root>
						<Header>
							<Agency>86600</Agency>
							<User>NYTXML</User>
							<Password>nyT@#!2019</Password>
							<Operation>TRANSFER_SEARCH_REQUEST</Operation>
							<OperationType>Request</OperationType>
						</Header>
						<Main>
							<PickUpType>'.$pickup_type.'</PickUpType>';
							
		if($info['pickup_type'] == 'airport'){
			$input_xml .='		<PickUpCode>'.$info["pickup_code"].'</PickUpCode>';     
		}elseif($info['pickup_type'] == 'hotel'){
			$input_xml .='		<PickUpCode type="hotel">'.$info["pickup_code"].'</PickUpCode>';  
		}elseif($info['pickup_type'] == 'city'){
			$input_xml .='		<PickUpCode type="city">'.$info["pickup_code"].'</PickUpCode>';  
		}
		
		if($info['dropoff_type'] == 'airport'){
			$input_xml .='		<DropOffCode>'.$info["dropoff_code"].'</DropOffCode>';     
		}elseif($info['dropoff_type'] == 'hotel'){
			$input_xml .='		<DropOffCode type="hotel">'.$info["dropoff_code"].'</DropOffCode>';  
		}elseif($info['dropoff_type'] == 'city'){
			$input_xml .='		<DropOffCode type="city">'.$info["dropoff_code"].'</DropOffCode>';  
		}
		
		$input_xml .='		<DropOffType>'.$dropoff_type.'</DropOffType>        
							<ArrivalDate>'.$travel_book_date.'</ArrivalDate>
							<Passengers>'.$info["passangers_count"].'</Passengers>
							<Currency>USD</Currency>
							<Language>E</Language>  
						</Main>
					</Root>
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->my_api($input_xml); //XML Request
		//echo '<pre>';print_R($results);die;
		//echo json_encode($results,true); die;
		$mydata = array();
		if($results){
			$offers = (array)$results['TransferResult'];
			$response['info']['searchID'] = $results['searchID'];
			$response['info']['total_offers'] = count($offers);
			$i=0;
			//echo '<pre>'; print_R($offers);die;
			if($offers){
				
				foreach($offers as $offer){
					$offer = (array)$offer;
					$mydata[$i]['ItemCode'] = $offer['ItemCode'];
					$mydata[$i]['Item_Text'] = $offer['Item_Text'];
					$mydata[$i]['Time_Text'] =  $offer['Time_Text'];
					$mydata[$i]['MaximumPassengers'] = $offer['MaximumPassengers'];
					$mydata[$i]['MaximumLuggage'] = $offer['MaximumLuggage'];
					$mydata[$i]['ConfirmationText'] = $offer['ConfirmationText'];
					$mydata[$i]['VehicleText'] = $offer['VehicleText'];
					$mydata[$i]['Vehicle_ID'] = $offer['Vehicle_ID'];
					$mydata[$i]['VehicleCode'] = $offer['VehicleCode'];
	
					$currency_id = 2;		//USD							
					$currency_detail2 = $this->get_currencyDetailById($currency_id); 
					$currency_symbol = $currency_detail2->symbol;						
					$currency_code_name = $currency_detail2->code;
					
					$mydata[$i]['SellingPrice'] = $offer['SellingPrice'];
					$mydata[$i]['SellingCurrency'] = $currency_symbol;
					$mydata[$i]['SellingCurrencyName'] = $currency_code_name;
					$mydata[$i]['VechicleType'] = $offer['VechicleType'];	
					$mydata[$i]['Thumbnail'] = env('APP_URL')."assets/img/travel-default.png";
					//$mydata[$i]['isCartAdded'] = 0;
					$cart = CartData::where('user_id',$user_id)->where('guest_user_id',$guest_user_id)->where('is_completed',0)->orderBy('id','desc')->limit(1)->first();	
/* 					if($cart){ 
						$CartItemsCount = CartItems :: select(DB::raw("COUNT(*) AS offercount"))->Join('travel_booking_details',function ($join){$join->on('cart_items.id','=','travel_booking_details.cart_items_id'); })->where('cart_items.cart_id',$cart->id)->where('travel_booking_details.item_code',$offer['ItemCode'])->where('travel_booking_details.vehicle_id',$offer['Vehicle_ID'])->first()->offercount;
						if($CartItemsCount>0){
							$mydata[$i]['isCartAdded'] = 1;
						}
					} */					
					$i++;
				}
			}
			
			$response['data'] = $mydata;
			$response['info']['error'] = 0;
		}
			return $response;
		
	}

	public function travel_booking_valuation($req){

		$info['searchID']  = '';		
		$info['ItemCode']  = '';		
		$info['VehicleID']  = '';		
		if(isset($req['search_id'])){ $info['searchID']  = $req['search_id']; }
		if(isset($req['item_code'])){ $info['ItemCode']  = $req['item_code']; }
		if(isset($req['vehicle_id'])){ $info['VehicleID']  = $req['vehicle_id']; }
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>18</requestType>
		<xmlRequest><![CDATA[
			<Root>
				<Header>
					<Agency>86600</Agency>
					<User>NYTXML</User>
					<Password>nyT@#!2019</Password>
					<Operation>TB_VALUATION_REQUEST</Operation>
					<OperationType>Request</OperationType>
				</Header>
				<Main>
					<searchID>'.$info["searchID"].'</searchID>
					<ItemCode>'.$info["ItemCode"].'</ItemCode>
					<VehicleID>'.$info["VehicleID"].'</VehicleID>
				</Main>
			</Root>			
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->my_api($input_xml); //XML Request
		//echo json_encode($results,true); die;
		if($results){
			$response['data'] = $results;
			$response['info']['error'] = 0;
		}
		if($response['info']['error'] == 0){
			return $response;
		}else{
			return false;
		}
		
	}
	
	public function travel_booking_insert($req){

		if(isset($req['book-date'])){ $info['book_date']  = $req['book-date']; }
		if(isset($req['travel_booking_details'])){ $tb_item = $info['travel_booking_details'] = $req['travel_booking_details']; }

		$input_xml = '';
		//header('Content-Type: application/xhtml+xml');
		$input_xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
		<soap:Body>
		<MakeRequest xmlns="http://www.goglobal.travel/">
		<requestType>19</requestType>
		<xmlRequest><![CDATA[
			<Root>
				<Header>
					<Agency>86600</Agency>
					<User>NYTXML</User>
					<Password>nyT@#!2019</Password>
					<Operation>TB_INSERT_REQUEST</Operation>
					<OperationType>Request</OperationType>
				</Header>
				<Main>
					<searchID>'.$tb_item->travel_search_id.'</searchID>
					<ItemCode>'.$tb_item->item_code.'</ItemCode>
					<VehicleID>'.$tb_item->vehicle_id.'</VehicleID>
					<ArrivingCityID>'.$tb_item->arriving_city_id.'</ArrivingCityID>
					<PickupTime>'.$tb_item->pickup_time.'</PickupTime>
					<DepartingToCityID>'.$tb_item->departing_city_id.'</DepartingToCityID>
					<DropOffTime>'.$tb_item->dropoff_time.'</DropOffTime>';
		if($tb_item->pickup_flight_no != ''){
			$input_xml .= ' <PickupFlightNumber>'.$tb_item->pickup_flight_no.'</PickupFlightNumber>';}
		if($tb_item->pickup_hotel_name != ''){
			$input_xml .= ' <PickupHotel>'.$tb_item->pickup_hotel_name.'</PickupHotel>';}
		if($tb_item->pickup_address != ''){
			$input_xml .= ' <PickupAddress>'.$tb_item->pickup_address.'</PickupAddress>';}
		if($tb_item->dropoff_flight_no != ''){
			$input_xml .= ' <DropOffFlightNumber>'.$tb_item->dropoff_flight_no.'</DropOffFlightNumber>';}
		if($tb_item->dropoff_hotel_name != ''){
			$input_xml .= ' <DropOffHotel>'.$tb_item->dropoff_hotel_name.'</DropOffHotel>';}
		if($tb_item->dropoff_address != ''){
			$input_xml .= ' <DropOffAddress>'.$tb_item->dropoff_address.'</DropOffAddress>';}
		$input_xml .= '<PassengersNum>'.$tb_item->passenger_count.'</PassengersNum>
					<PassengerName>'.$tb_item->passenger_name.'</PassengerName>
					<Remarks>'.$tb_item->remarks.'</Remarks>
				</Main>
			</Root>			
		]]></xmlRequest>
		</MakeRequest>
		</soap:Body>
		</soap:Envelope>';
		//echo $input_xml;die;
		$response = array();
		$response['data'] = array();
		$response['info'] = $info;
		$results = array();  
		$response['info']['error'] = 1;
		$results = $this->booking_api($input_xml); //XML Request
		//echo json_encode($results,true); die;
		if($results){
			$response['data'] = $results;
			$response['info']['error'] = 0;
		}
		if($response['info']['error'] == 0){
			return $response;
		}else{
			return false;
		}
	}	
	//BlueSnap Payment Gateway
	public function get_payment_token($req){
		//$url = 'https://sandbox.bluesnap.com/services/2/payment-fields-tokens'; //Sandbox
		$url = 'https://ws.bluesnap.com/services/2/payment-fields-tokens'; //Production
		$headers = [
		 'Accept:application/json',
		 'Content-Type: application/json',
		 //'Authorization: Basic QVBJXzE1NTA5MTY0NDU5MDYyMDg0NDAyOTA2Om55dFN0YXlAIyEyMDE5' //Sandbox
		 'Authorization: Basic QVBJXzE1NTE3NzcwNzAxNzIxNDI4NzI4OTU1Om55dFN0YXlAIyEyMDE5TlM='
		 ];
		 
		$data = '';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_USERPWD, " : "); 
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data );
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT,        30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_POST,true );
		
		$http = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$response = curl_exec($curl);
		// echo '<pre>';print_R($response);echo '</pre>';
		$hd2 = curl_getinfo($curl);
		// echo curl_error($curl);
		curl_close($curl);
		
		// echo '<pre>';print_R($hd2);echo '</pre>';die;
		if (strpos($response, 'HTTP/1.1 201 201') !== false) {
			//$pos1 = strpos($response,"https://sandbox.bluesnap.com/services/2/payment-fields-tokens/"); //Sandbox
			$pos1 = strpos($response,"https://ws.bluesnap.com/services/2/payment-fields-tokens/"); //Production
			$pos2 = strpos($response,"Content-Length");
			$resp = substr($response, $pos1 , ($pos2 - $pos1) );
			$resp =  trim($resp);
			$resp =  explode($url."/",$resp);
			$result = $resp[1];
			return $result; 
			
		}else{
			return false;
		}		
	}
	
	public function do_payment($data){
		//echo $data;die;
		//$url = 'https://sandbox.bluesnap.com/services/2/transactions'; //Sandbox
		$url = 'https://ws.bluesnap.com/services/2/transactions'; //Production
		$headers = [
		 'Accept:application/json',
		 'Content-Type: application/json',
		// 'Authorization: Basic QVBJXzE1NTA5MTY0NDU5MDYyMDg0NDAyOTA2Om55dFN0YXlAIyEyMDE5' //Sandbox
		 'Authorization: Basic QVBJXzE1NTE3NzcwNzAxNzIxNDI4NzI4OTU1Om55dFN0YXlAIyEyMDE5TlM=' //Production
		 ];
		 
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERPWD, " : "); 
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data );
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		$http = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$response = curl_exec($curl);
		//echo '<pre>';print_R($response);echo '</pre>';
		$hd2 = curl_getinfo($curl);
		//echo '<pre>';print_R($hd2);die;
		curl_close($curl);
		$res = array();
		if($response!=''){
			
			$res = json_decode($response);
			$res = (array)$res;
			if($res){
				if(isset($res['processingInfo'])){
					$processingInfo = (array)$res['processingInfo'];
					if(isset($processingInfo['processingStatus']) && $processingInfo['processingStatus'] == 'success'){
						return $res;
					}
				}
			}else{
				return false;
			}
		}
	
	}	
}

?>