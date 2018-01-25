<?php

namespace AmazonMWS;

/**
 * Core class for Amazon Subscriptions API.
 *
 * This is the core class for all objects in the Amazon Subscriptions section.
 * It contains a method that all Amazon Subscriptions Core objects use.
 */
abstract class AmazonSubscriptionCore extends AmazonCore{

    /**
     * AmazonSubscriptionCore constructor sets up key information used in all Amazon Subscriptions Core requests
     *
     * This constructor is called when initializing all objects in the Amazon Subscriptions Core.
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

        if (isset($AMAZON_VERSION_SUBSCRIBE)){
            $this->urlbranch = 'Subscriptions/' . $AMAZON_VERSION_SUBSCRIBE;
            $this->options['Version'] = $AMAZON_VERSION_SUBSCRIBE;
        }

        if(isset($THROTTLE_LIMIT_SUBSCRIBE)) {
            $this->throttleLimit = $THROTTLE_LIMIT_SUBSCRIBE;
        }
        if(isset($THROTTLE_TIME_SUBSCRIBE)) {
            $this->throttleTime = $THROTTLE_TIME_SUBSCRIBE;
        }
    }

    /**
     * Sets the marketplace associated with the subscription or destination. (Optional)
     *
     * The current store's configured marketplace is used by default.
     * @param string $m <p>Marketplace ID</p>
     * @return boolean <b>FALSE</b> if improper input
     */
    public function setMarketplace($m){
        if (is_string($m)){
            $this->options['MarketplaceId'] = $m;
        } else {
            return false;
        }
    }

}
