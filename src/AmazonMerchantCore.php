<?php

namespace AmazonMWS;

/**
 * Core class for Amazon Merchant Fulfillment API.
 *
 * This is the core class for all objects in the Amazon Merchant Fulfillment section.
 * It contains no methods in itself other than the constructor.
 */
abstract class AmazonMerchantCore extends AmazonCore{
    /**
     * AmazonMerchantCore constructor sets up key information used in all Amazon Merchant Core requests
     *
     * This constructor is called when initializing all objects in the Amazon Merchant Core.
     * The parameters are passed by the child objects' constructors, which are
     * in turn passed to the AmazonCore constructor. See it for more information
     * on these parameters and common methods.
     * @param array $config <p>The config file containing seller credentials and log settings</p>
     * @param boolean $mock [optional] <p>This is a flag for enabling Mock Mode.
     * This defaults to <b>FALSE</b>.</p>
     * @param array|string $m [optional] <p>The files (or file) to use in Mock Mode.</p>
     * @param string $config [optional] <p>An alternate config file to set. Used for testing.</p>
     */
    public function __construct($config, $mock = false, $m = null){
        parent::__construct($config, $mock, $m);
        include($this->env);

        if(isset($AMAZON_VERSION_MERCHANT)){
            $this->urlbranch = 'MerchantFulfillment/'.$AMAZON_VERSION_MERCHANT;
            $this->options['Version'] = $AMAZON_VERSION_MERCHANT;
        }

        if(isset($THROTTLE_LIMIT_MERCHANT)) {
            $this->throttleLimit = $THROTTLE_LIMIT_MERCHANT;
        }
        if(isset($THROTTLE_TIME_MERCHANT)) {
            $this->throttleTime = $THROTTLE_TIME_MERCHANT;
        }
        $this->throttleGroup = 'MerchantFulfillment';
    }
}
