<?php
/**
 * DO NOT EDIT THIS FILE!
 *
 * This file was automatically generated from external sources.
 *
 * Any manual change here will be lost the next time the SDK
 * is updated. You've been warned!
 */

namespace DTS\eBaySDK\Marketing\Types;

/**
 *
 * @property string[] $campaignIds
 * @property string $dateFrom
 * @property string $dateTo
 * @property \DTS\eBaySDK\Marketing\Types\Dimension[] $dimensions
 * @property \DTS\eBaySDK\Marketing\Types\InventoryReference[] $inventoryReferences
 * @property string[] $listingIds
 * @property \DTS\eBaySDK\Marketing\Types\Bas:MarketplaceIdEnum $marketplaceId
 * @property string[] $metricKeys
 * @property string $reportExpirationDate
 * @property \DTS\eBaySDK\Marketing\Enums\ReportFormatEnum $reportFormat
 * @property string $reportHref
 * @property string $reportId
 * @property string $reportName
 * @property string $reportTaskCompletionDate
 * @property string $reportTaskCreationDate
 * @property string $reportTaskExpectedCompletionDate
 * @property string $reportTaskId
 * @property \DTS\eBaySDK\Marketing\Enums\TaskStatusEnum $reportTaskStatus
 * @property string $reportTaskStatusMessage
 * @property \DTS\eBaySDK\Marketing\Enums\ReportTypeEnum $reportType
 */
class ReportTask extends \DTS\eBaySDK\Types\BaseType
{
    /**
     * @var array Properties belonging to objects of this class.
     */
    private static $propertyTypes = [
        'campaignIds' => [
            'type' => 'string',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'campaignIds'
        ],
        'dateFrom' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'dateFrom'
        ],
        'dateTo' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'dateTo'
        ],
        'dimensions' => [
            'type' => 'DTS\eBaySDK\Marketing\Types\Dimension',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'dimensions'
        ],
        'inventoryReferences' => [
            'type' => 'DTS\eBaySDK\Marketing\Types\InventoryReference',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'inventoryReferences'
        ],
        'listingIds' => [
            'type' => 'string',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'listingIds'
        ],
        'marketplaceId' => [
            'type' => 'DTS\eBaySDK\Marketing\Types\Bas:MarketplaceIdEnum',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'marketplaceId'
        ],
        'metricKeys' => [
            'type' => 'string',
            'repeatable' => true,
            'attribute' => false,
            'elementName' => 'metricKeys'
        ],
        'reportExpirationDate' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportExpirationDate'
        ],
        'reportFormat' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportFormat'
        ],
        'reportHref' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportHref'
        ],
        'reportId' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportId'
        ],
        'reportName' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportName'
        ],
        'reportTaskCompletionDate' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportTaskCompletionDate'
        ],
        'reportTaskCreationDate' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportTaskCreationDate'
        ],
        'reportTaskExpectedCompletionDate' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportTaskExpectedCompletionDate'
        ],
        'reportTaskId' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportTaskId'
        ],
        'reportTaskStatus' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportTaskStatus'
        ],
        'reportTaskStatusMessage' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportTaskStatusMessage'
        ],
        'reportType' => [
            'type' => 'string',
            'repeatable' => false,
            'attribute' => false,
            'elementName' => 'reportType'
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

        $this->setValues(__CLASS__, $childValues);
    }
}
