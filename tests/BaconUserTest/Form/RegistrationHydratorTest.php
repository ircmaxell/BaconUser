<?php
/**
 * BaconUser
 *
 * @link      http://github.com/Bacon/BaconUser For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace BaconUserTest\Form;

use BaconUser\Entity\User;
use BaconUser\Form\RegistrationHydrator;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers BaconUser\Form\RegistrationHydrator
 */
class RegistrationHydratorTest extends TestCase
{
    public function testHydrate()
    {
        $hashingStrategy = $this->getMock('Zend\Stdlib\Hydrator\Strategy\StrategyInterface');
        $hashingStrategy->expects($this->once())
                        ->method('hydrate')
                        ->with($this->equalTo('foobar'))
                        ->will($this->returnValue('bazbat'));

        $hydrator = new RegistrationHydrator($hashingStrategy);
        $user     = new User();

        $hydrator->hydrate(
            array(
                'email'        => 'foobar@example.com',
                'password'     => 'foobar',
                'username'     => 'example',
                'display_name' => 'Example',
            ),
            $user
        );

        $this->assertEquals('foobar@example.com', $user->getEmail());
        $this->assertEquals('bazbat', $user->getPasswordHash());
        $this->assertEquals('example', $user->getUsername());
        $this->assertEquals('Example', $user->getDisplayName());
    }
}
