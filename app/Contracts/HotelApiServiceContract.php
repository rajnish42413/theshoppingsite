<?php
namespace App\Contracts;

interface HotelApiServiceContract {
    public function hotel_search($info);
    public function hotel_detail($info);
    public function hotel_info($info);
    public function price_breakdown($info);
    public function booking_valuation($info);
    public function booking_insert($info);
    public function booking_status($info);
    public function cancel_booking($info);
    public function voucher_detail($info);
    public function get_cityName($cityId);
    public function get_countryName($countryId);
    public function get_currencyDetail($currencyCode);
    public function get_currencyDetailbyId($currencyId);
    public function convert_currency($from_currency,$to_currency,$amount);
    public function send_email($info,$file,$attachment='');
    public function get_hotel_cities($req);
	
    public function travel_search($req);
    public function get_travel_places($req);
    public function travel_booking_valuation($req);
    public function travel_booking_insert($info);	
    public function get_payment_token($info);	
    public function do_payment($info);	
	

}
