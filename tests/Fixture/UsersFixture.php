<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'email' => 'swap@gmail.com',
                'password' => '1234',
                'created' => '2024-04-03 08:19:24',
                'modified' => '2024-04-03 08:19:24',
            ],
        ];
        parent::init();
    }
}
