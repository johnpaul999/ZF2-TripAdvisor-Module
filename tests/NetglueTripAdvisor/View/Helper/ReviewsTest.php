<?php

namespace NetglueTripAdvisor\View\Helper;

class ReviewsTest extends \Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase
{

    private $helper;

    public function setUp()
    {
        $this->setTraceError(false);
        $this->setApplicationConfig(include __DIR__ . '/../../../TestConfig.php.dist');
        parent::setUp();
        $services = $this->getApplicationServiceLocator();
        $manager = $services->get('ViewHelperManager');
        $this->helper = $manager->get('tripAdvisor');
    }

    public function testInstanceCreated()
    {
        $this->assertInstanceOf('NetglueTripAdvisor\View\Helper\Reviews', $this->helper);
    }

    public function testGetReviews()
    {
        $reviews = $this->helper->getReviews();
        $this->assertInternalType('array', $reviews);
        $this->assertGreaterThan(1, count($reviews));

        $one = $this->helper->getReviews(1);
        $this->assertCount(1, $one);
        $this->assertSame(current($reviews), current($one));

        $this->assertContainsOnlyInstancesOf('NetglueTripAdvisor\Model\Review', $reviews);
    }

    public function testRenderViewScript()
    {
        $markup = (string) $this->helper;
        $this->assertInternalType('string', $markup);
    }

}

