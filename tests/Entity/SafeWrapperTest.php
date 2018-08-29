<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Entity;

use Exception;
use PHPUnit\Framework\TestCase;

class SafeWrapperTest extends TestCase
{
    /**
     * @param $customerId
     * @param $customerSentence
     *
     * @throws Exception
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

    public function testOverrideNonObjectMethodOutput(): void
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

    public function testOverrideNonObjectPropertyOutput(): void
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

    public function testOverrideNonObjectPropertySet(): void
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

    public function testFunctionalMethodsStillWork(): void
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

    public function testNoWrappedObject(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No wrapped object defined. Did you forget to call [wrap]?');

        $safeCustomer = new SafeWrapper();

        $safeCustomer->getId();
    }

    public function testPropertyDoesNotExist(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Undefined property Linio\\SafeEcho\\Entity\\Customer::$getDNExist');

        $safeCustomer = $this->getSafeCustomer(1, 'sentence');

        $safeCustomer->getDNExist;
    }

    public function testMethodDoesNotExist(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Call to undefined method Linio\\SafeEcho\\Entity\\Customer::getDNExist()');

        $safeCustomer = $this->getSafeCustomer(1, 'sentence');

        $safeCustomer->getDNExist();
    }

    public function testDoesNotWrapString(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Only objects can be wrapped');

        $safeCustomer = new SafeWrapper();

        $safeCustomer->wrap('nothing');
    }

    public function testDoesNotWrapArray(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Only objects can be wrapped');

        $safeCustomer = new SafeWrapper();

        $safeCustomer->wrap([]);
    }
}
