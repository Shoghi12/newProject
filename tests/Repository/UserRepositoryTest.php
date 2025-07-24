<?php

namespace App\Tests\Repository;

use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

class UserRepositoryTest extends KernelTestCase 
{
public function testCount()
{
    self::bootKernel();
    
    $databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
    
    $databaseTool->loadAliceFixture([
        __DIR__.'/UserRepositoryTestFixtures.yaml'
    ]);
    
    $userCount = self::getContainer()->get(UserRepository::class)->count([]);
    $this->assertEquals(10, $userCount);
}
}