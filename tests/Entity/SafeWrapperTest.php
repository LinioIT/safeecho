<?php

declare(strict_types=1);

namespace Linio\SafeEcho\tests\Entity;

use Error;
use Linio\SafeEcho\Entity\SafeEchoEntityWrapper;
use Linio\SafeEcho\Entity\SafeWrapper;
use PHPUnit\Framework\TestCase;

class SafeWrapperTest extends TestCase
{
    /**
     * @param $customerId
     * @param $customerSentence
     *
     * @throws Error
     *
     * @return SafeEchoEntityWrapper
     */
    public function getSafeCustomer($customerId, $customerSentence)
    {
        $customer = new Customer($customerId, $customerSentence);

        $safeCustomer = new SafeWrapper();

        $safeCustomer->wrap($customer);

        return $safeCustomer;
    }

    public function testOverrideNonObjectMethodOutput()
    {
        $safeCustomer = $this->getSafeCustomer(
            987654321,
            'I am a long sentence with many Wondrous things 2 show you 2day.'
        );

        $this->assertEquals('9********', $safeCustomer->getId());
        $this->assertEquals(
            'I a* a l*** s******* w*** m*** W******* t***** 2 s*** y** 2****',
            $safeCustomer->getSentence()
        );
    }

    public function testOverrideNonObjectPropertyOutput()
    {
        $safeCustomer = $this->getSafeCustomer(
            987654321,
            'I am a long sentence with many Wondrous things 2 show you 2day.'
        );

        $this->assertEquals('9********', $safeCustomer->id);
        $this->assertEquals(
            'I a* a l*** s******* w*** m*** W******* t***** 2 s*** y** 2****',
            $safeCustomer->sentence
        );
    }

    public function testOverrideNonObjectPropertySet()
    {
        $safeCustomer = $this->getSafeCustomer(
            987654321,
            'I am a long sentence with many Wondrous things 2 show you 2day.'
        );

        $safeCustomer->id = 65656565;
        $safeCustomer->sentence = 'No matter where you go I will find you.';

        $this->assertEquals('6*******', $safeCustomer->id);
        $this->assertEquals(
            'N* m***** w**** y** g* I w*** f*** y***',
            $safeCustomer->sentence
        );
    }

    public function testFunctionalMethodsStillWork()
    {
        $safeCustomer = $this->getSafeCustomer(
            0,
            'nothing'
        );

        $safeCustomer->setId(1234567890);
        $this->assertEquals('1*********', $safeCustomer->getId());
        $this->assertEquals('1*********', $safeCustomer->id);

        $safeCustomer->setSentence('Let\'s see something @new');
        $this->assertEquals('L**** s** s******** @***', $safeCustomer->getSentence());
        $this->assertEquals('L**** s** s******** @***', $safeCustomer->sentence);
    }

    /**
     * @expectedException Error
     * @expectedExceptionMessage No wrapped object defined. Did you forget to call [wrap]?
     */
    public function testNoWrappedObject()
    {
        $safeCustomer = new SafeWrapper();

        $safeCustomer->getId();
    }

    /**
     * @expectedException Error
     * @expectedExceptionMessage Undefined property Linio\SafeEcho\tests\Entity\Customer::$getDNExist
     */
    public function testPropertyDoesNotExist()
    {
        $safeCustomer = $this->getSafeCustomer(1, 'sentence');

        $safeCustomer->getDNExist;
    }

    /**
     * @expectedException Error
     * @expectedExceptionMessage Call to undefined method Linio\SafeEcho\tests\Entity\Customer::getDNExist()
     */
    public function testMethodDoesNotExist()
    {
        $safeCustomer = $this->getSafeCustomer(1, 'sentence');

        $safeCustomer->getDNExist();
    }

    /**
     * @expectedException Error
     * @expectedExceptionMessage Only objects can be wrapped
     */
    public function testDoesNotWrapString()
    {
        $safeCustomer = new SafeWrapper();

        $safeCustomer->wrap('nothing');
    }

    /**
     * @expectedException Error
     * @expectedExceptionMessage Only objects can be wrapped
     */
    public function testDoesNotWrapArray()
    {
        $safeCustomer = new SafeWrapper();

        $safeCustomer->wrap([]);
    }
}
