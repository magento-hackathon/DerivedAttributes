<?php
/**
 * Abstract controller class that provides DOM assertions for the response body
 */
abstract class Hackathon_DerivedAttributes_Test_Case_Controller_Dom extends EcomDev_PHPUnit_Test_Case_Controller
{
    public static function assertResponseBodyQuery($path, $message = '')
    {
        self::assertResponseBody(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery($path), $message
        );
    }

    public static function assertResponseBodyNotQuery($path, $message = '')
    {
        self::assertResponseBodyNot(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery($path), $message
        );
    }

    public static function assertResponseBodyQueryCount(
        $path, $count, $message = '')
    {
        self::assertResponseBody(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery(
                $path,
                Hackathon_DerivedAttributes_Test_Constraint_DomQuery::ASSERT_CONTENT_COUNT,
                $count
            ), $message
        );
    }

    public static function assertResponseBodyQueryContains(
        $path, $content, $message = '')
    {
        self::assertResponseBody(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery(
                $path,
                Hackathon_DerivedAttributes_Test_Constraint_DomQuery::ASSERT_CONTENT_CONTAINS,
                $content
            ), $message
        );
    }

    public static function assertResponseBodyNotQueryContains(
        $path, $content, $message = '')
    {
        self::assertResponseBodyNot(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery(
                $path,
                Hackathon_DerivedAttributes_Test_Constraint_DomQuery::ASSERT_CONTENT_CONTAINS,
                $content
            ), $message
        );
    }

    public static function assertResponseBodyQueryRegex(
        $path, $regex, $message = '')
    {
        self::assertResponseBody(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery(
                $path,
                Hackathon_DerivedAttributes_Test_Constraint_DomQuery::ASSERT_CONTENT_REGEX,
                $regex
            ), $message
        );
    }

    public static function assertResponseBodyXpath($path, $message = '')
    {
        self::assertResponseBody(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery(
                $path, Hackathon_DerivedAttributes_Test_Constraint_DomQuery::ASSERT_XPATH
            ), $message
        );
    }

    public static function assertResponseBodyNotXpath($path, $message = '')
    {
        self::assertResponseBodyNot(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery(
                $path, Hackathon_DerivedAttributes_Test_Constraint_DomQuery::ASSERT_XPATH
            ), $message
        );
    }


    public static function assertResponseBodyXpathCount(
        $path, $count, $message = '')
    {
        self::assertResponseBody(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery(
                $path,
                Hackathon_DerivedAttributes_Test_Constraint_DomQuery::ASSERT_XPATH_CONTENT_COUNT,
                $count
            ), $message
        );
    }

    public static function assertResponseBodyXpathContains(
        $path, $content, $message = '')
    {
        self::assertResponseBody(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery(
                $path,
                Hackathon_DerivedAttributes_Test_Constraint_DomQuery::ASSERT_XPATH_CONTENT_CONTAINS,
                $content
            ), $message
        );
    }

    public static function assertResponseBodyNotXpathContains(
        $path, $content, $message = '')
    {
        self::assertResponseBodyNot(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery(
                $path,
                Hackathon_DerivedAttributes_Test_Constraint_DomQuery::ASSERT_XPATH_CONTENT_CONTAINS,
                $content
            ), $message
        );
    }

    public static function assertResponseBodyXpathRegex(
        $path, $regex, $message = '')
    {
        self::assertResponseBody(
            new Hackathon_DerivedAttributes_Test_Constraint_DomQuery(
                $path,
                Hackathon_DerivedAttributes_Test_Constraint_DomQuery::ASSERT_XPATH_CONTENT_REGEX,
                $regex
            ), $message
        );
    }

}