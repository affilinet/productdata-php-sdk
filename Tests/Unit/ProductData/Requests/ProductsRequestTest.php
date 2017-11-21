<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * {@inheritDoc}
 */
class ProductsRequestTest extends \PHPUnit_Framework_TestCase
{

    protected $affilinetClient;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $log = new \Monolog\Logger('testlog');
        $log->pushHandler(new \Monolog\Handler\TestHandler());

        $this->affilinetClient = new \Affilinet\ProductData\AffilinetClient(
            [
                'log' => $log,
                'publisher_id' => \Affilinet\Tests\AffilinetTestCredentials::$publisherId,
                'product_webservice_password' => \Affilinet\Tests\AffilinetTestCredentials::$productWebservicePassword
            ]
        );

    }

    public function testExcludeShopIds()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->excludeShopIds([123, 234, 456, 567567567]);
        $this->assertEquals('ShopIds=123%2C234%2C456%2C567567567&ShopIdMode=Exclude', $search->serialize());
    }

    /**
     * @expectedException \Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException
     */
    public function testExcludeShopIdsCanNotBeUsedWithOnlyFromShopIds()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search
            ->excludeShopIds([123, 234, 456, 567567567])
            ->onlyFromShopIds([123, '123']);
    }

    public function testOnlyFromShopIds()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyFromShopIds([123, 234, 456, 567567567]);
        $this->assertEquals('ShopIds=123%2C234%2C456%2C567567567&ShopIdMode=Include', $search->serialize());
    }

    public function testOnlyFromShopIdsLogsWarningIfTooManyShopIds()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        foreach ($search->getAffilinetClient()->getLog()->getHandlers() as $handler) {
            if ($handler instanceof \Monolog\Handler\TestHandler) {
                $testHandler = $handler;
                break;
            }
        }

        if (!isset($testHandler)) {
            throw new \RuntimeException('Oops, not exist "test" handler in monolog.');
        }

        $array = [];
        for ($i = 1; $i <= 501; $i++) {
            $array[] = $i;
        }
        $search->onlyFromShopIds($array);
        $this->assertTrue($testHandler->hasWarningThatContains('Some shopIds have been ignored'));

    }

    /**
     * @expectedException \Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException
     */
    public function testOnlyFromShopIdsCanNotBeUsedWithExcludeShopIds()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search
            ->onlyFromShopIds([123, '123'])
            ->excludeShopIds([123, 234, 456, 567567567]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOnlyFromShopIdsArrayMustNotBeEmpty()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search
            ->onlyFromShopIds([]);

    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOnlyFromShopIdsThrowsWarningOnIllegalShopId()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search
            ->onlyFromShopIds(['aosdiaosdi', '123']);

    }

    public function testFilterToCategories()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyFromCategories([123, 345, 456, 456]);
        $this->assertEquals('CategoryIds=123%2C345%2C456%2C456&ExcludeSubCategories=false&UseAffilinetCategories=true', $search->serialize());
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyFromCategories([123, 345, 456, 456], true, false);
        $this->assertEquals('CategoryIds=123%2C345%2C456%2C456&ExcludeSubCategories=true&UseAffilinetCategories=false', $search->serialize());
        $search->onlyFromCategories([123, 345, 456, 456], true, true);
        $this->assertEquals('CategoryIds=123%2C345%2C456%2C456&ExcludeSubCategories=true&UseAffilinetCategories=true', $search->serialize());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFilterToCategoriesCategoriesArrayMustNotBeEmpty()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyFromCategories([]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFilterToCategoriesCategoryIdMustNotBeZero()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyFromCategories([0]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFilterToCategoriesCategoryIdMustNotBeFloat()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyFromCategories([1.2]);
    }

    /**
     * @expectedException OverflowException
     */
    public function testFilterToCategoriesDoesNotAcceptMoreThan100CategoryIds()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $array = [];
        for ($i = 1; $i <= 101; $i++) {
            $array[] = $i;
        }
        $search->onlyFromCategories($array);
    }

    public function testOnlyWithImage()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyWithImage();
        $this->assertEquals('ImageScales=OriginalImage&WithImageOnly=true', $search->serialize());
    }

    public function testAddProductImage()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addProductImage();
        $this->assertEquals('ImageScales=OriginalImage', $search->serialize());
    }

    public function testAddProductImageWithSizes()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search
            ->addProductImageWithSize30px()
            ->addProductImageWithSize60px()
            ->addProductImageWithSize90px()
            ->addProductImageWithSize120px()
            ->addProductImageWithSize180px();
        $this->assertEquals('ImageScales=Image30%2CImage60%2CImage90%2CImage120%2CImage180', $search->serialize());
    }

    public function testAddProductImageWithSizesIsOnlyAddedOnce()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search
            ->addProductImageWithSize30px()
            ->addProductImageWithSize30px()
            ->addProductImageWithSize60px()
            ->addProductImageWithSize60px()
            ->addProductImageWithSize90px()
            ->addProductImageWithSize90px()
            ->addProductImageWithSize120px()
            ->addProductImageWithSize120px()
            ->addProductImageWithSize180px()
            ->addProductImageWithSize180px();
        $this->assertEquals('ImageScales=Image30%2CImage60%2CImage90%2CImage120%2CImage180', $search->serialize());
    }

    public function testAddShopLogoWithSizes()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search
            ->addShopLogoWithSize468px()
            ->addShopLogoWithSize150px()
            ->addShopLogoWithSize120px()
            ->addShopLogoWithSize90px()
            ->addShopLogoWithSize50px();

        $this->assertEquals('LogoScales=Logo468%2CLogo150%2CLogo120%2CLogo90%2CLogo50', $search->serialize());
    }

    public function testAddShopLogoWithSizeIsOnlyAddedOnce()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search
            ->addShopLogoWithSize468px()
            ->addShopLogoWithSize468px()
            ->addShopLogoWithSize468px()
            ->addShopLogoWithSize468px()
            ->addShopLogoWithSize120px()
            ->addShopLogoWithSize120px()
            ->addShopLogoWithSize120px()
            ->addShopLogoWithSize120px()
            ->addShopLogoWithSize90px()
            ->addShopLogoWithSize90px()
            ->addShopLogoWithSize90px()
            ->addShopLogoWithSize90px()
            ->addShopLogoWithSize50px()
            ->addShopLogoWithSize50px()
            ->addShopLogoWithSize50px()
            ->addShopLogoWithSize50px();

        $this->assertEquals('LogoScales=Logo468%2CLogo120%2CLogo90%2CLogo50', $search->serialize());
    }/** @noinspection PhpInconsistentReturnPointsInspection */

    /**
     * @return mixed
     */
    public function testPage()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->page();
        $this->assertEquals('CurrentPage=1', $search->serialize());
        $search->page(2);
        $this->assertEquals('CurrentPage=2', $search->serialize());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPageMustBeInteger()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->page('asv');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPageMustNotBeZero()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->page(0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPageMustNotBeGreaterOrLessThan500000()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->page(50000);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPageMustNotBeFloat()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->page(1.43);
    }

    public function testPageSize()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->pageSize(500);
        $this->assertEquals('PageSize=500', $search->serialize());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPageSizeMustNotBeZero()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->pageSize(0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPageSizeMustNotBeGreaterThan500()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->pageSize(501);
    }

    public function testSort()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        // Score DESC
        $search->sort(\Affilinet\ProductData\Requests\ProductsRequest::SORT_BY_RELEVANCE);
        $this->assertEquals('SortBy=Score&SortOrder=descending', $search->serialize());

        // Score ASC
        $search->sort(\Affilinet\ProductData\Requests\ProductsRequest::SORT_BY_RELEVANCE, false);
        $this->assertEquals('SortBy=Score&SortOrder=ascending', $search->serialize());

        // Price
        $search->sort(\Affilinet\ProductData\Requests\ProductsRequest::SORT_BY_PRICE);
        $this->assertEquals('SortBy=Price&SortOrder=descending', $search->serialize());

        // ProductName
        $search->sort(\Affilinet\ProductData\Requests\ProductsRequest::SORT_BY_PRODUCT_NAME);
        $this->assertEquals('SortBy=ProductName&SortOrder=descending', $search->serialize());

        // ProductName
        $search->sort(\Affilinet\ProductData\Requests\ProductsRequest::SORT_BY_LAST_PROGRAM_LIST_UPDATE);
        $this->assertEquals('SortBy=LastImported&SortOrder=descending', $search->serialize());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSortThrowsInvalidArgumentExceptionIfWrongSortParam()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        // Score DESC
        $search->sort('Category');

    }

    public function testMinPrice()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);

        // use integer
        $search->minPrice(10);
        $this->assertEquals('MinimumPrice=10.00', $search->serialize());

        // use float
        $search->minPrice(10000.001);
        $this->assertEquals('MinimumPrice=10000.00', $search->serialize());

        // use float
        $search->minPrice(10000.009);
        $this->assertEquals('MinimumPrice=10000.01', $search->serialize());

        // use float
        $search->minPrice(0.01);
        $this->assertEquals('MinimumPrice=0.01', $search->serialize());

        // use string
        $search->minPrice("0.01");
        $this->assertEquals('MinimumPrice=0.01', $search->serialize());

        $search->minPrice("10000.009");
        $this->assertEquals('MinimumPrice=10000.01', $search->serialize());

        $search->minPrice("10.00");
        $this->assertEquals('MinimumPrice=10.00', $search->serialize());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMinPriceThrowsInvalidArgumentExceptionWhenStringContainsThousandSeparator()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->minPrice("1.000,01");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMinPriceThrowsInvalidArgumentExceptionWhenStringContainsComma()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->minPrice("1,000");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMinPriceThrowsInvalidArgumentExceptionWhenNonNumericString()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->minPrice("sdflkj");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMinPriceThrowsInvalidArgumentExceptionWhenObject()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->minPrice(new ArrayObject());
    }

    public function testMaxPrice()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);

        // use integer
        $search->maxPrice(10);
        $this->assertEquals('MaximumPrice=10.00', $search->serialize());

        // use float
        $search->maxPrice(10000.001);
        $this->assertEquals('MaximumPrice=10000.00', $search->serialize());

        // use float
        $search->maxPrice(10000.009);
        $this->assertEquals('MaximumPrice=10000.01', $search->serialize());

        // use float
        $search->maxPrice(0.01);
        $this->assertEquals('MaximumPrice=0.01', $search->serialize());

        // use string
        $search->maxPrice("0.01");
        $this->assertEquals('MaximumPrice=0.01', $search->serialize());

        $search->maxPrice("10000.009");
        $this->assertEquals('MaximumPrice=10000.01', $search->serialize());

        $search->maxPrice("10.00");
        $this->assertEquals('MaximumPrice=10.00', $search->serialize());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMaxPriceThrowsInvalidArgumentException()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->maxPrice("1.000,01");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMaxPriceThrowsInvalidArgumentException2()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->maxPrice("1,000");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMaxPriceThrowsInvalidArgumentException3()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->maxPrice("sdflkj");
    }

    public function testAddFacetArticleNumber()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFacetArticleNumber();
        $this->assertEquals('FacetFields=ArticleNumber&FacetValueLimit=20', $search->serialize());
    }

    public function testAddFacetBrand()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFacetBrand();
        $this->assertEquals('FacetFields=Brand&FacetValueLimit=20', $search->serialize());
    }

    public function testAddFacetDistributor()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFacetDistributor();
        $this->assertEquals('FacetFields=Distributor&FacetValueLimit=20', $search->serialize());
    }

    public function testAddFacetEAN()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFacetEAN();
        $this->assertEquals('FacetFields=EAN&FacetValueLimit=20', $search->serialize());
    }

    public function testAddFacetManufacturer()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFacetManufacturer();
        $this->assertEquals('FacetFields=Manufacturer&FacetValueLimit=20', $search->serialize());
    }

    public function testAddFacetProgramId()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFacetProgramId();
        $this->assertEquals('FacetFields=ProgramId&FacetValueLimit=20', $search->serialize());
    }

    public function testAddFacetShopId()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFacetShopId();
        $this->assertEquals('FacetFields=ShopId&FacetValueLimit=20', $search->serialize());
    }

    public function testAddFacetShopName()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFacetShopName();
        $this->assertEquals('FacetFields=ShopName&FacetValueLimit=20', $search->serialize());
    }

    public function testAddFourFacets()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFacetAffilinetCategoryId()
            ->addFacetAffilinetCategoryPath()
            ->addFacetShopCategoryId()
            ->addFacetShopCategoryPath();
        $this->assertEquals('FacetFields=AffilinetCategoryId%2CAffilinetCategoryPathFacet%2CShopCategoryId%2CShopCategoryPathFacet&FacetValueLimit=20', $search->serialize());
    }

    public function testFacetsWillNotBeAddedTwice()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search
            ->addFacetAffilinetCategoryId()
            ->addFacetAffilinetCategoryId()
            ->addFacetAffilinetCategoryId()
            ->addFacetAffilinetCategoryId()
            ->addFacetAffilinetCategoryPath()
            ->addFacetAffilinetCategoryPath()
            ->addFacetAffilinetCategoryPath()
            ->addFacetAffilinetCategoryPath()
            ->addFacetShopCategoryId()
            ->addFacetShopCategoryId()
            ->addFacetShopCategoryId()
            ->addFacetShopCategoryId()
            ->addFacetShopCategoryPath()
            ->addFacetShopCategoryPath()
            ->addFacetShopCategoryPath()
            ->addFacetShopCategoryPath();
        $this->assertEquals('FacetFields=AffilinetCategoryId%2CAffilinetCategoryPathFacet%2CShopCategoryId%2CShopCategoryPathFacet&FacetValueLimit=20', $search->serialize());
    }

    /**
     * @expectedException \OverflowException
     */

    public function testCanNotAddMoreThanFourFacets()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search
            ->addFacetProgramId()
            ->addFacetAffilinetCategoryId()
            ->addFacetAffilinetCategoryPath()
            ->addFacetShopCategoryId()
            ->addFacetShopCategoryPath();
        $this->assertEquals('FacetFields=AffilinetCategoryId%2CAffilinetCategoryPathFacet%2CShopCategoryId%2CShopCategoryPathFacet', $search->serialize());
    }

    public function testUnserialize()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $serializedSearch = 'FacetFields=AffilinetCategoryId%2CAffilinetCategoryPathFacet%2CShopCategoryId%2CShopCategoryPathFacet';
        $this->assertEquals($serializedSearch, $search->unserialize($serializedSearch)->serialize());
    }

    public function testAddFilterQuery()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFilterQuery('test', '123');
        $this->assertEquals('FQ=test%3A123', $search->serialize());

        $search->addFilterQuery('test2', '2342');
        $this->assertEquals('FQ=test%3A123%2Ctest2%3A2342', $search->serialize());
    }

    public function testAddFilterQueryFilterQueryCanNotBeAddedTwice()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFilterQuery('test', '123');
        $search->addFilterQuery('test', '345');
        $this->assertEquals('FQ=test%3A123', $search->serialize());
    }

    /**
     * @expectedException OverflowException
     */
    public function testFindCanOnlyAdd50Ids()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);

        $ids = [];
        $i = 0;
        while ($i < 51) {
            $ids[] = $i;
            $i++;
        }
        $search->find($ids);
    }

    public function testOnlyFromShopCategory()
    {
        $data = [
            'Id' => '2345',
            'IdPath' => '',
            'Title' => '',
            'TitlePath' => '',
            'ProductCount' => '',
        ];
        $category = new \Affilinet\ProductData\Responses\ResponseElements\Category($data);

        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyFromShopCategory($category);
        $this->assertEquals('CategoryIds=2345&ExcludeSubCategories=false&UseAffilinetCategories=false', $search->serialize());
    }

    public function testOnlyFromShopCategories()
    {
        $data = [
            'Id' => '2345',
            'IdPath' => '',
            'Title' => '',
            'TitlePath' => '',
            'ProductCount' => '',
        ];
        $data2 = [
            'Id' => '2235534',
            'IdPath' => '',
            'Title' => '',
            'TitlePath' => '',
            'ProductCount' => '',
        ];
        $category[] = new \Affilinet\ProductData\Responses\ResponseElements\Category($data);
        $category[] = new \Affilinet\ProductData\Responses\ResponseElements\Category($data2);

        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyFromShopCategories($category);
        $this->assertEquals('CategoryIds=2345%2C2235534&ExcludeSubCategories=false&UseAffilinetCategories=false', $search->serialize());

    }

    public function testOnlyFromShop()
    {
        $data = [
            'ShopId' => '2345',
            'LastUpdate' => '/Date(1468928770807+0200)/',
            'ProductCount' => '2',
            'ProgramId' => 987654321,
            'ShopLink' => 'https://www.example.com',
            'ShopTitle' => 'example',
        ];
        $shop = new \Affilinet\ProductData\Responses\ResponseElements\Shop($data);
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyFromShop($shop);
        $this->assertEquals('ShopIds=2345&ShopIdMode=Include', $search->serialize());
    }

    public function testOnlyFromShops()
    {
        $data = [
            'ShopId' => '2345',
            'LastUpdate' => '/Date(1468928770807+0200)/',
            'ProductCount' => '2',
            'ProgramId' => 987654321,
            'ShopLink' => 'https://www.example.com',
            'ShopTitle' => 'example',
        ];
        $data2 = [
            'ShopId' => '987657',
            'LastUpdate' => '/Date(1468928743807+0200)/',
            'ProductCount' => '502',
            'ProgramId' => 5234234,
            'ShopLink' => 'https://www.example.de',
            'ShopTitle' => 'test',
        ];
        $shops[] = new \Affilinet\ProductData\Responses\ResponseElements\Shop($data);
        $shops[] = new \Affilinet\ProductData\Responses\ResponseElements\Shop($data2);
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->onlyFromShops($shops);
        $this->assertEquals('ShopIds=2345%2C987657&ShopIdMode=Include', $search->serialize());
    }

    public function testQueryBuilder()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $query = new \Affilinet\ProductData\Requests\Helper\Query();

        $search->query(
            $query->where(
                $query->expr()->exactly('test')
                    ->containsOneOf('sdf', 's4p', '9340fhj')
                    ->containsNot('mia', 'fsdoij')
            )
            ->andWhere($query->expr()->containsAllOf('mai', 'pdoskf'))

        );
        $this->assertEquals('Query=+%28+%22test%22++OR++sdf++OR++s4p++OR++9340fhj++NOT++NOT++mia++NOT++fsdoij++%29++AND++%28+mai++AND++pdoskf++%29+', $search->serialize());
    }

    public function testQueryBuilderWhere()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $query = new \Affilinet\ProductData\Requests\Helper\Query();

        $search->query(
            $query
                ->where($query->expr()->exactly('test'))
                ->where($query->expr()->exactly('test2'))
                ->where($query->expr()->exactly('test3'))
                ->orWhere($query->expr()->containsAllOf('test4', 'test5'))
        );
        $this->assertEquals('Query=+%28+%22test%22++%29++AND++%28+%22test2%22++%29++AND++%28+%22test3%22++%29++OR++%28+test4++AND++test5++%29+', $search->serialize());
    }

    public function testQueryBuilderContains()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $query = new \Affilinet\ProductData\Requests\Helper\Query();

        $search->query(
            $query
                ->where($query->expr()
                    ->contains('test1')
                    ->containsNot('test2'))
                ->orWhere($query->expr()
                    ->exactly('test3')
                    ->contains('test4'))
        );
        $this->assertEquals('Query=+%28+test1++NOT+%22test2%22++%29++OR++%28+%22test3%22++AND++test4++%29+', $search->serialize());
    }

    /**
     * @expectedException \Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException
     */
    public function testProductRequestMustNotBeEmpty()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->send();
    }
}
