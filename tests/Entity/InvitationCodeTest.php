<?php

namespace App\Tests\Entity;

use App\Entity\InvitationCode;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InvitationCodeTest extends KernelTestCase
{
    public function getEntity (): invitationCode
    {
        return $code = (new InvitationCode())
            ->setCode('12345')
            ->setDescription('Description de test')
            ->setExpireAt(new \DateTime('+1 day'));
    }

    public function assertHasErrors(InvitationCode $code, int $number = 0)
    {
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($code);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
         $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidEntity ()
    {
       $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankCodeEntity ()
    {
        $this->assertHasErrors($this->getEntity()->setCode(''), 1);
    }

    public function testInvalidBlankDescriptionEntity ()
    {
        $this->assertHasErrors($this->getEntity()->setDescription(''), 1);
    }

    public function testInvalidUsedCode ()
    { 
        $databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
    
        $databaseTool->loadAliceFixture([
        dirname(__DIR__).'/fixtures/InvitationCode.yaml'
        ]);
        $this->assertHasErrors($this->getEntity()->setCode('54321'), 1);
        
    }

    //afficher l'erreur
//     public function testNotBlankInvalidEntity()
// {
//     $code = $this->getEntity()->setCode('1');
    
 
//     self::bootKernel();
//     $validator = self::getContainer()->get('validator');
//     $errors = $validator->validate($code);
    

//     if (count($errors) > 0) {
//         echo "\n\033[31mERREURS DE VALIDATION TROUVÉES:\033[0m\n";
//         foreach ($errors as $error) {
//             echo sprintf(
//                 " - \033[33m%s\033[0m: %s\n",
//                 $error->getPropertyPath(),
//                 $error->getMessage()
//             );
//         }
//     } else {
//         echo "\n\033[32mAUCUNE ERREUR TROUVÉE (mais on s'attendait à des erreurs)\033[0m\n";
//     }
    
 
//     $this->assertHasErrors($code, 1);
// }
    


}