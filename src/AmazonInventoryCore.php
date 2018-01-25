<?php

namespace SellerCrew\AmazonMWS;

/**
 * Core class for Amazon Inventory API.
 *
 * This is the core class for the only object in the Amazon Inventory section.
 * It contains no methods in itself other than the constructor.
 */
abstract class AmazonInventoryCore extends AmazonCore{
    /**
     * AmazonInventoryCore constructor sets up key information used in all Amazon Inventory Core requests
     *
     * This constructor is called when initializing all objects in the Amazon Inventory Core.
     * The parameters are passed by the child objects' constructors, which are
     * in turn passed to the AmazonCore constructor. See it for more information
     * on these parameters and common methods.
     * @param string $s [optional] <p>Name for the store you want to use.
     * This parameter is optional if only one store is defined in the config file.</p>
     * @param boolean $mock [optional] <p>This is a flag for enabling Mock Mode.
     * This defaults to <b>FALSE</b>.</p>
     * @param array|string $m [optional] <p>The files (or file) to use in Mock Mode.</p>
     * @param string $config [optional] <p>An alternate config file to set. Used for testing.</p>
     */
    public function __construct($s = null, $mock = false, $m = null, $config = null){
        parent::__construct($s, $mock, $m, $config);
        include($this->env);

        if(isset($AMAZON_VERSION_INVENTORY)){
            $this->urlbranch = 'FulfillmentInventory/'.$AMAZON_VERSION_INVENTORY;
            $this->options['Version'] = $AMAZON_VERSION_INVENTORY;
        }

        if(isset($THROTTLE_LIMIT_INVENTORY)) {
            $this->throttleLimit = $THROTTLE_LIMIT_INVENTORY;
        }
        if(isset($THROTTLE_TIME_INVENTORY)) {
            $this->throttleTime = $THROTTLE_TIME_INVENTORY;
        }
        $this->throttleGroup = 'Inventory';
    }
}
?>
