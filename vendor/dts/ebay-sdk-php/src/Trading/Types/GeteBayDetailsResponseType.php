<?php
/**
 * DO NOT EDIT THIS FILE!
 *
 * This file was automatically generated from external sources.
 *
 * Any manual change here will be lost the next time the SDK
 * is updated. You've been warned!
 */

namespace DTS\eBaySDK\Trading\Types;

/**
 *
 * @property \DTS\eBaySDK\Trading\Types\CountryDetailsType[] $CountryDetails
 * @property \DTS\eBaySDK\Trading\Types\CurrencyDetailsType[] $CurrencyDetails
 * @property \DTS\eBaySDK\Trading\Types\DispatchTimeMaxDetailsType[] $DispatchTimeMaxDetails
 * @property \DTS\eBaySDK\Trading\Types\PaymentOptionDetailsType[] $PaymentOptionDetails
 * @property \DTS\eBaySDK\Trading\Types\RegionDetailsType[] $RegionDetails
 * @property \DTS\eBaySDK\Trading\Types\ShippingLocationDetailsType[] $ShippingLocationDetails
 * @property \DTS\eBaySDK\Trading\Types\ShippingServiceDetailsType[] $ShippingServiceDetails
 * @property \DTS\eBaySDK\Trading\Types\SiteDetailsType[] $SiteDetails
 * @property \DTS\eBaySDK\Trading\Types\TaxJurisdictionType[] $TaxJurisdiction
 * @property \DTS\eBaySDK\Trading\Types\URLDetailsType[] $URLDetails
 * @property \DTS\eBaySDK\Trading\Types\TimeZoneDetailsType[] $TimeZoneDetails
 * @property \DTS\eBaySDK\Trading\Types\ItemSpecificDetailsType[] $ItemSpecificDetails
 * @property \DTS\eBaySDK\Trading\Types\RegionOfOriginDetailsType[] $RegionOfOriginDetails
 * @property \DTS\eBaySDK\Trading\Types\ShippingPackageDetailsType[] $ShippingPackageDetails
 * @property \DTS\eBaySDK\Trading\Types\ShippingCarrierDetailsType[] $ShippingCarrierDetails
 * @property \DTS\eBaySDK\Trading\Types\ReturnPolicyDetailsType $ReturnPolicyDetails
 * @property \DTS\eBaySDK\Trading\Types\ListingStartPriceDetailsType[] $ListingStartPriceDetails
 * @property \DTS\eBaySDK\Trading\Types\SiteBuyerRequirementDetailsType[] $BuyerRequirementDetails
 * @property \DTS\eBaySDK\Trading\Types\ListingFeatureDetailsType[] $ListingFeatureDetails
 * @property \DTS\eBaySDK\Trading\Types\VariationDetailsType $VariationDetails
 * @property \DTS\eBaySDK\Trading\Types\ExcludeShippingLocationDetailsType[] $ExcludeShippingLocationDetails
 * @property \DateTime $UpdateTime
 * @property \DTS\eBaySDK\Trading\Types\RecoupmentPolicyDetailsType[] $RecoupmentPolicyDetails
 * @property \DTS\eBaySDK\Trading\Types\ShippingCategoryDetailsType[] $ShippingCategoryDetails
 * @property \DTS\eBaySDK\Trading\Types\ProductDetailsType $ProductDetails
 */
class GeteBayDetailsResponseType extends \DTS\eBaySDK\Trading\Types\AbstractResponseType
{
    /**
     * @var array Properties belonging to objects of this class.
     */
    private static $propertyTypes = [
        'CountryDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\CountryDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'CountryDetails'
        ],
        'CurrencyDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\CurrencyDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'CurrencyDetails'
        ],
        'DispatchTimeMaxDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\DispatchTimeMaxDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'DispatchTimeMaxDetails'
        ],
        'PaymentOptionDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\PaymentOptionDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'PaymentOptionDetails'
        ],
        'RegionDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\RegionDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'RegionDetails'
        ],
        'ShippingLocationDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ShippingLocationDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'ShippingLocationDetails'
        ],
        'ShippingServiceDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ShippingServiceDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'ShippingServiceDetails'
        ],
        'SiteDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\SiteDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'SiteDetails'
        ],
        'TaxJurisdiction' => [
            'type' => 'DTS\eBaySDK\Trading\Types\TaxJurisdictionType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'TaxJurisdiction'
        ],
        'URLDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\URLDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'URLDetails'
        ],
        'TimeZoneDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\TimeZoneDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'TimeZoneDetails'
        ],
        'ItemSpecificDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ItemSpecificDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'ItemSpecificDetails'
        ],
        'RegionOfOriginDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\RegionOfOriginDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'RegionOfOriginDetails'
        ],
        'ShippingPackageDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ShippingPackageDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'ShippingPackageDetails'
        ],
        'ShippingCarrierDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ShippingCarrierDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'ShippingCarrierDetails'
        ],
        'ReturnPolicyDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ReturnPolicyDetailsType',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'ReturnPolicyDetails'
        ],
        'ListingStartPriceDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ListingStartPriceDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'ListingStartPriceDetails'
        ],
        'BuyerRequirementDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\SiteBuyerRequirementDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'BuyerRequirementDetails'
        ],
        'ListingFeatureDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ListingFeatureDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'ListingFeatureDetails'
        ],
        'VariationDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\VariationDetailsType',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'VariationDetails'
        ],
        'ExcludeShippingLocationDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ExcludeShippingLocationDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'ExcludeShippingLocationDetails'
        ],
        'UpdateTime' => [
            'type' => 'DateTime',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'UpdateTime'
        ],
        'RecoupmentPolicyDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\RecoupmentPolicyDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'RecoupmentPolicyDetails'
        ],
        'ShippingCategoryDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ShippingCategoryDetailsType',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'ShippingCategoryDetails'
        ],
        'ProductDetails' => [
            'type' => 'DTS\eBaySDK\Trading\Types\ProductDetailsType',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'ProductDetails'
        ]
    ];

    /**
     * @param array $values Optional properties and values to assign to the object.
     */
    public function __construct(array $values = [])
    {
        list($parentValues, $childValues) = self::getParentValues(self::$propertyTypes, $values);

        parent::__construct($parentValues);

        if (!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = array_merge(self::$properties[get_parent_class()], self::$propertyTypes);
        }

        if (!array_key_exists(__CLASS__, self::$xmlNamespaces)) {
            self::$xmlNamespaces[__CLASS__] = 'xmlns="urn:ebay:apis:eBLBaseComponents"';
        }

        $this->setValues(__CLASS__, $childValues);
    }
}
