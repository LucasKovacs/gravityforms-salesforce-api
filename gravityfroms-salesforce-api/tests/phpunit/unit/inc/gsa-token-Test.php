<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers Gsa_Token
 */
class Gsa_TokenTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function setUp(): void
    {

    }

    /**
     * @coversNothing
     */
    public function tearDown(): void
    {
        unset($_SESSION['_token']);
    }

    /**
     * @covers Gsa_Token::generateToken
     */
    public function testCreateANewSessionWhenSessionIsEmpty(): void
    {
        $object = new Gsa_Token;

        // check if it's empty
        $this->assertFalse(isset($_SESSION['_token']));

        $object->generateToken();

        $this->assertNotEmpty(
            $_SESSION['_token']
        );
    }

    /**
     * @covers Gsa_Token::generateToken
     */
    public function testCreateANewSessionWhenSessionExists(): void
    {
        // create object
        $object = new Gsa_Token;

        // check if it's empty
        $this->assertFalse(isset($_SESSION['_token']));

        // create new one
        $token = $object->generateToken();

        // check if it's not empty
        $this->assertNotEmpty(
            $_SESSION['_token']
        );

        // try to create new one
        $existing_token = $object->generateToken();

        // check if it's not empty
        $this->assertNotEmpty(
            $_SESSION['_token']
        );

        // since already existed must be both the same
        $this->assertEquals(
            $token, $existing_token
        );
    }

    /**
     * @covers Gsa_Token::verifyToken
     */
    public function testTokenNotExistsInSession(): void
    {
        // create object
        $object = new Gsa_Token;

        // random token to validate
        $random_token = md5(uniqid(microtime(), true));

        $this->assertFalse($object->verifyToken($random_token));
    }

    /**
     * @covers Gsa_Token::verifyToken
     */
    public function testNotIssetReceivedToken(): void
    {
        // create object
        $object = new Gsa_Token;

        // create a token
        $object->generateToken();

        // random token without purpose
        $random_token = md5(uniqid(microtime(), true));

        $this->assertFalse($object->verifyToken(null));
    }

    /**
     * @covers Gsa_Token::verifyToken
     */
    public function testReceivedTokenNotExistsInSession(): void
    {
        // create object
        $object = new Gsa_Token;

        // random token, will represent an old token
        $random_token = md5(uniqid(microtime(), true));

        // generate a new token, that will be stored in session
        $object->generateToken();

        $this->assertFalse($object->verifyToken($random_token));
    }

    /**
     * @covers Gsa_Token::verifyToken
     */
    public function testReceviedTokenExistsInSession(): void
    {
        // create object
        $object = new Gsa_Token;

        // generate a token
        $generated_token = $object->generateToken();

        $this->assertTrue($object->verifyToken($generated_token));
    }

    /**
     * @covers Gsa_Token::unsetToken
     */
    public function testCreatedTokenIsUnset(): void
    {
        // create object
        $object = new Gsa_Token;

        // check if it's empty
        $this->assertFalse(isset($_SESSION['_token']));

        // generate a token
        $object->generateToken();

        // check if it's not empty
        $this->assertNotEmpty(
            $_SESSION['_token']
        );

        // unset a token
        $object->unsetToken();

        // check if it's empty
        $this->assertFalse(isset($_SESSION['_token']));
    }
}

/* End of gsa-token-Test.php */
