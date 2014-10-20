<?php

namespace NetglueTripAdvisor;

use NetglueTripAdvisor\bootstrap;

class ScraperTest extends \PHPUnit_Framework_TestCase
{

    private $reviews;

    private $fixtureHtml;

    public function setUp() {
        $this->fixtureHtml = file_get_contents( __DIR__.'/../fixtures/LondonRitz.html' );
    }

    public function testCreateFactoryInstance()
    {
        $services = bootstrap::getServiceManager();
        $scraper = $services->get('NetglueTripAdvisor\Scraper');
        $this->assertInstanceOf('NetglueTripAdvisor\Scraper', $scraper);
        return $scraper;
    }

    /**
     * @depends testCreateFactoryInstance
     */
    public function testHttpClientBasic(Scraper $scraper)
    {
        $client = $scraper->getHttpClient();
        $this->assertInstanceOf('Zend\Http\Client', $client);
    }

    /**
     * @depends testCreateFactoryInstance
     */
    public function testHttpClientCanBeReplaced(Scraper $scraper)
    {
        $oldClient = $scraper->getHttpClient();

        $client = new \Zend\Http\Client;
        $scraper->setHttpClient($client);
        $this->assertSame($client, $scraper->getHttpClient());

        $scraper->setHttpClient($oldClient);
    }

    /**
     * @depends testCreateFactoryInstance
     */
    public function testOptionsAreAvailable(Scraper $scraper)
    {
        $options = $scraper->getOptions();
        $url = $options->getUrl();
        $this->assertGreaterThan(10, strlen($url));
        $this->assertSame($options->getUrl(), (string) $scraper->getHttpClient()->getUri());
    }

    /**
     * Don't run this method unless you want the tests to fail...
     * There are a few tests that rely on the content of the file, so if TA change
     * something, the entire test case will need to be updated
     *
     * @depends testCreateFactoryInstance
     */
    public function cacheHtmlForFixture(Scraper $scraper)
    {
        $html = $scraper->getHtml();
        file_put_contents(__DIR__ .' /../fixtures/LondonRitz.html', $html);
    }

    /**
     * @depends testCreateFactoryInstance
     * @expectedException NetglueTripAdvisor\Exception\RuntimeException
     * @expectedExceptionMessage Failed to load remote source HTML
     */
    public function testExceptionThrownForUnreachableUrl(Scraper $scraper)
    {
        $scraper->getHttpClient()->setUri('http://foo.bar.example.com/unknown.html');
        $scraper->getHtml();
    }

    /**
     * @depends testCreateFactoryInstance
     * @expectedException NetglueTripAdvisor\Exception\RuntimeException
     * @expectedExceptionMessage Failed to load remote source HTML
     */
    public function testExceptionThrownFor404(Scraper $scraper)
    {
        $scraper->getHttpClient()->setUri('https://www.google.com/this-file-does-not-exist');
        $scraper->getHtml();
    }

    /**
     * Return an array of reviews from the fixture html
     */
    public function getReviews()
    {
        if(!$this->reviews) {
            $services = bootstrap::getServiceManager();
            $scraper = $services->get('NetglueTripAdvisor\Scraper');
            $scraper->setHtml($this->fixtureHtml);
            $this->reviews = $scraper->extract();
        }

        return $this->reviews;
    }

    /**
     * @depends testCreateFactoryInstance
     */
    public function testExtractReturnsReviews(Scraper $scraper)
    {
        $reviews = $this->getReviews();
        $this->assertContainsOnlyInstancesOf('NetglueTripAdvisor\Model\Review', $reviews);
    }


    public function testExpectedValues()
    {
        $reviews = $this->getReviews();
        $review = current($reviews);

        $this->assertEquals('Easternwinds2', $review->getAuthor());
        $this->assertEquals('London, United Kingdom', $review->getAuthorLocation());
        $this->assertEquals('Good, but not quite as excellent as one would expect', $review->getTitle());
        $this->assertStringStartsWith('Have been staying at The Ritz three times over the course of the last twelve months', $review->getExcerpt());
        $this->assertEquals(4, $review->getStarRating());
        $this->assertEquals(5, $review->getMaxStarRating());
        $this->assertSame($review->getExcerpt(), $review->getBody());
        $this->assertSame($review->getDate(), $review->getDateCreated());
        $this->assertInstanceOf('DateTime', $review->getDate());
        $this->assertEquals('19/10/2014', $review->getDate()->format('d/m/Y'));
        $this->assertEquals('http://www.tripadvisor.co.uk/ShowUserReviews-g186338-d187591-r235227923-The_Ritz_London-London_England.html', $review->getLink());
    }

    public function testUtf8Encoding()
    {
        $reviews = $this->getReviews();
        $last = end($reviews);
        $this->assertEquals('ปฏิภาณ แ', $last->getAuthor());
    }


}
