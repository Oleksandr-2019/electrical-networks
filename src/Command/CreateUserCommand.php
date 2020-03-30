<?php
// src/Command/CreateUserCommand.php
namespace App\Command;


use App\Entity\User;
use App\Service\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class CreateUserCommand extends Command
{

    // Пыдключення сервісу UserManager
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;

        parent::__construct();
    }

    // імя команди піля "bin/console"
    protected static $defaultName = 'app:create-user';

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Створення нового юзера.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Ця команда створює юзера...')

            //->addArgument('password', $this->requirePassword ? InputArgument::REQUIRED : InputArgument::OPTIONAL, 'User password')
            ->addArgument('nickname', InputArgument::REQUIRED, 'Нікнейм для юзераr.')
            ->addArgument('roles', InputArgument::REQUIRED, 'Роль юзера.')
            ->addArgument('password', InputArgument::REQUIRED, 'Пароль юзера.')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Іде процес створення юзера',
            '============',
            '',
        ]);

        // the value returned by someMethod() can be an iterator (https://secure.php.net/iterator)
        // that generates and returns the messages with the 'yield' PHP keyword
        //$output->writeln($this->someMethod());

        // outputs a message followed by a "\n"
        $output->writeln('Ура!');

        //Просто візуальне відображення того що буде записано в базу даних
        $output->write('Ви тількищо');
        $output->write('створили з наступним');
        $output->writeln(' справжнім паролем: '.$input->getArgument('nickname'));
        $output->writeln(' і він має таку роль: '.$input->getArgument('roles').'.');
        $output->writeln('Створений пароль: '.$input->getArgument('password'));

        //Блок команд які використовуються для запису в базу даних - беруться з UserManager який в Service
        $this->userManager->setNickname($input->getArgument('nickname'));
        $this->userManager->setPassword($input->getArgument('password'));

        $rolesArray = array($input->getArgument('roles')); //перетворює string в array для майбутнього присвоювання

        $this->userManager->setRoles($rolesArray);
        $this->userManager->index();

        return 1;
        // ПРИКЛАД КОМАНДИ ЯКУ ТРЕБА ВВОДИТЬ В КОНСОЛІ І ЯКА СТВОРИТЬ ЮЗЕРА
        // php bin/console app:create-user Inna ROLE_ADMIN 123456

    }
}