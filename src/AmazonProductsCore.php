<?php

namespace AmazonMWS;

/**
 * Core class for Amazon Products API.
 *
 * This is the core class for all objects in the Amazon Products section.
 * It contains a few methods that all Amazon Products Core objects use.
 */
abstract class AmazonProductsCore extends AmazonCore{
    protected $productList;
    protected $index = 0;

    /**
     * AmazonProductsCore constructor sets up key information used in all Amazon Products Core requests
     *
     * This constructor is called when initializing all objects in the Amazon Products Core.
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

        if(isset($AMAZON_VERSION_PRODUCTS)){
            $this->urlbranch = 'Products/'.$AMAZON_VERSION_PRODUCTS;
            $this->options['Version'] = $AMAZON_VERSION_PRODUCTS;
        }

        if(isset($THROTTLE_LIMIT_PRODUCT)) {
            $this->throttleLimit = $THROTTLE_LIMIT_PRODUCT;
        }
    }

    /**
     * Sets the marketplace to search in. (Optional)
     * Setting this option tells Amazon to only return products from the given marketplace.
     * If this option is not set, the current store's marketplace will be used.
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

    /**
     * Parses XML response into array.
     *
     * This is what reads the response XML and converts it into an array.
     * @param SimpleXMLElement $xml <p>The XML response from Amazon.</p>
     * @return boolean <b>FALSE</b> if no XML data is found
     */
    protected function parseXML($xml){
        if (!$xml){
            return false;
        }

        foreach($xml->children() as $x){
            if($x->getName() == 'ResponseMetadata'){
                continue;
            }
            $temp = (array)$x->attributes();
            if (isset($temp['@attributes']['status']) && $temp['@attributes']['status'] != 'Success'){
                $this->log("Warning: product return was not successful",'Warning');
            }
            if (isset($x->Products)){
                foreach($x->Products->children() as $z){
                    $this->productList[$this->index] = new AmazonProduct($this->config, $z, $this->mockMode, $this->mockFiles);
                    if (isset($temp['@attributes'])) {
                        $this->productList[$this->index]->data['Identifiers']['Request'] = $temp['@attributes'];
                    }
                    $this->index++;
                }
            } else if (in_array($x->getName(), array('GetProductCategoriesForSKUResult', 'GetProductCategoriesForASINResult',
                    'GetLowestPricedOffersForSKUResult', 'GetLowestPricedOffersForASINResult'))){
                $this->productList[$this->index] = new AmazonProduct($this->config, $x, $this->mockMode, $this->mockFiles);
                $this->index++;
            } else {
                foreach($x->children() as $z){
                    if($z->getName() == 'Error'){
                        $error = (string)$z->Message;
                        $this->productList['Error'] = $error;
                        $this->log("Product Error: $error",'Warning');
                    } elseif($z->getName() != 'Product'){
                        $this->productList[$z->getName()] = (string)$z;
                        $this->log("Special case: ".$z->getName(),'Warning');
                    } else {
                        $this->productList[$this->index] = new AmazonProduct($this->config, $z, $this->mockMode, $this->mockFiles);
                        $this->index++;
                    }
                }
            }
        }
    }

    /**
     * Returns product specified or array of products.
     *
     * See the <i>AmazonProduct</i> class for more information on the returned objects.
     * @param int $num [optional] <p>List index to retrieve the value from. Defaults to 0.</p>
     * @return AmazonProduct|array Product (or list of Products)
     */
    public function getProduct($num = null){
        if (!isset($this->productList)){
            return false;
        }
        if (is_numeric($num)){
            return $this->productList[$num];
        } else {
            return $this->productList;
        }
    }
}
?>
