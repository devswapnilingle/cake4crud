<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;
namespace App\Test\TestCase\Model\Table;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

use App\Model\Table\ArticlesTable;
use Cake\ORM\TableRegistry; 


/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Users' ,
        'app.Article',
    ];

    public $Articles;

    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Articles') ? [] : ['className' => ArticlesTable::class];
        $this->Articles = TableRegistry::getTableLocator()->get('Articles', $config);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $articleData = [
            'title' => 'Test Article',
            'body' => 'This is a test article.',
            'user_id' => 1
        ];
        $article = $this->Articles->newEmptyEntity();
        $article = $this->Articles->patchEntity($article, $articleData);
        $result = $this->Articles->save($article);
        $this->assertInstanceOf('App\Model\Entity\Article', $result);
        $this->assertNotNull($result->id);
        $this->assertEquals($articleData['title'], $result->title);
        $this->assertEquals($articleData['body'], $result->body);
    }


    /**
     * Test update method
     *
     * @return void
     */
    public function testUpdate()
    {
        $article = $this->Articles->find()->first();
        $articleData = [
            'title' => 'Updated Article',
            'body' => 'This is an updated article.',
            'user_id' => 1
        ];
        $article = $this->Articles->patchEntity($article, $articleData);
        $result = $this->Articles->save($article);
        $this->assertInstanceOf('App\Model\Entity\Article', $result);
        $this->assertEquals($articleData['title'], $result->title);
        $this->assertEquals($articleData['body'], $result->body);
    }


     /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        
        $article = $this->Articles->find()->first();
        $result = $this->Articles->delete($article);
        $this->assertTrue($result);
        $article = $this->Articles->find()->where(['id' => $article->id])->first();
        $this->assertNull($article);
    }



    // public function testAddUnauthenticatedFails(): void
    // {
        

    //     // No session data set.
    //     $this->get('/articles/add');
    //     $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
        
    // }

    public function testAddAuthenticated(): void
    {
        // Set session data
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'email' => 'swap@gmail.com',
                    // other keys.
                ]
            ]
        ]);
        $this->get('/articles/add');

        $this->assertResponseOk();
        // Other assertions.
    }
    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\UsersController::index()
     */
    // public function testLoginWithValidCredentials()
    // {
    //     $this->enableCsrfToken();
    //     // $this->enableSecurityToken();
 
    //      // Perform the login request
    //     $this->post('/users/login', ['email' => 'swap@gmail.com', 'password' => '1234']); 
        
    //     $this->assertRedirect(['controller' => 'Articles', 'action' => 'index']);
    //     $this->assertSession('swap@gmail.com', 'Auth.User.email');
        
    // }

    // public function testLoginWithInvalidCredentials()
    // {
    //     $this->enableCsrfToken();
    //     $this->enableSecurityToken();
    //     $this->post('/users/login', ['username' => 'swap@gmail.com', 'password' => 'incorrect_password']);
    //     $this->assertResponseContains('Invalid username or password');
    //     $this->assertResponseCode(401); // Adjust to match the HTTP status code returned for failed login attempts
    // }

    // public function testLogout()
    // {
    //     $this->session(['Auth' => ['User' => ['id' => 1, 'username' => 'admin']]]);
    //     $this->get('/users/logout');
    //     $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    //     $this->assertSession(null, 'Auth');
    // }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\UsersController::view()
     */
    // public function testView(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\UsersController::add()
     */
    // public function testAdd(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\UsersController::edit()
     */
    // public function testEdit(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\UsersController::delete()
     */
    // public function testDelete(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
}
