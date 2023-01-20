<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117162508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO `task_type`(`id`, `type`, `state`) VALUES (1,'WORK','enabled')");
        $this->addSql("INSERT INTO `task_type`(`id`, `type`, `state`) VALUES (2,'ROUTINE','enabled')");
    }

    public function down(Schema $schema): void
    {
        
    }
}
