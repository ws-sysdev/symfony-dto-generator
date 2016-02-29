<?php

namespace WsSys\DtoGeneratorBundle\Tests\Generator\Reader;

use WsSys\DtoGeneratorBundle\Generator\Reader\XsdReader;


class XsdReaderTest extends \PhpUnit_Framework_TestCase
{
    /**
     * @var Reader 
     */
    private $reader;
    
    private $source;
        
    public function setUp() 
    {
        $this->source = __DIR__ . '/../XSD/PO.xsd';
        $this->reader = new XsdReader();
        parent::setUp();
    }
    
    public function testGetFirstElementWithChildrenReturnElementsWithItsChildren()
    {
        $this->reader->read($this->source);
        $retval = $this->reader->getFirstElementWithChildren();
        
        $this->assertCount(12, $retval->getChildren());
        $this->assertInstanceOf('WsSys\DtoGeneratorBundle\Generator\Reader\Xsd\Element', $retval->getChildren()[0]);
        $this->assertCount(3, $retval->getComplexElementChildren());
        
        $this->assertEquals('clientOrderId', $retval->getChildren()[0]->getName());
        $this->assertEquals('purchaseNo', $retval->getChildren()[1]->getName());
        $this->assertEquals('extractionCentre', $retval->getChildren()[2]->getName());
        $this->assertEquals('catalogId', $retval->getChildren()[3]->getName());
        $this->assertEquals('string', $retval->getChildren()[3]->getDataType());
        $this->assertEquals('clientId', $retval->getChildren()[4]->getName());
        $this->assertEquals('vendorId', $retval->getChildren()[5]->getName());
        $this->assertEquals('internal', $retval->getChildren()[6]->getName());
        $this->assertEquals('shipDate', $retval->getChildren()[7]->getName());
        $this->assertEquals('countryOfOrigin', $retval->getChildren()[8]->getName());
        $this->assertEquals('shippingAddress', $retval->getChildren()[9]->getName());
        $this->assertEquals('billingAddress', $retval->getChildren()[10]->getName());
        $this->assertEquals('lines', $retval->getChildren()[11]->getName());
    }
}