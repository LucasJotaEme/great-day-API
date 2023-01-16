<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116182938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE summary ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE summary ADD CONSTRAINT FK_CE286663A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CE286663A76ED395 ON summary (user_id)');
        $this->addSql('ALTER TABLE summary_data_task ADD task_type_id INT DEFAULT NULL, ADD summary_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE summary_data_task ADD CONSTRAINT FK_7B56BB2DAADA679 FOREIGN KEY (task_type_id) REFERENCES task_type (id)');
        $this->addSql('ALTER TABLE summary_data_task ADD CONSTRAINT FK_7B56BB22AC2D45C FOREIGN KEY (summary_id) REFERENCES summary (id)');
        $this->addSql('CREATE INDEX IDX_7B56BB2DAADA679 ON summary_data_task (task_type_id)');
        $this->addSql('CREATE INDEX IDX_7B56BB22AC2D45C ON summary_data_task (summary_id)');
        $this->addSql('ALTER TABLE task ADD user_id INT DEFAULT NULL, ADD task_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25DAADA679 FOREIGN KEY (task_type_id) REFERENCES task_type (id)');
        $this->addSql('CREATE INDEX IDX_527EDB25A76ED395 ON task (user_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25DAADA679 ON task (task_type_id)');
        $this->addSql('ALTER TABLE user ADD worker_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499381A8D8 FOREIGN KEY (worker_user_id) REFERENCES worker_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6499381A8D8 ON user (worker_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE summary DROP FOREIGN KEY FK_CE286663A76ED395');
        $this->addSql('DROP INDEX IDX_CE286663A76ED395 ON summary');
        $this->addSql('ALTER TABLE summary DROP user_id');
        $this->addSql('ALTER TABLE summary_data_task DROP FOREIGN KEY FK_7B56BB2DAADA679');
        $this->addSql('ALTER TABLE summary_data_task DROP FOREIGN KEY FK_7B56BB22AC2D45C');
        $this->addSql('DROP INDEX IDX_7B56BB2DAADA679 ON summary_data_task');
        $this->addSql('DROP INDEX IDX_7B56BB22AC2D45C ON summary_data_task');
        $this->addSql('ALTER TABLE summary_data_task DROP task_type_id, DROP summary_id');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A76ED395');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25DAADA679');
        $this->addSql('DROP INDEX IDX_527EDB25A76ED395 ON task');
        $this->addSql('DROP INDEX IDX_527EDB25DAADA679 ON task');
        $this->addSql('ALTER TABLE task DROP user_id, DROP task_type_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499381A8D8');
        $this->addSql('DROP INDEX UNIQ_8D93D6499381A8D8 ON user');
        $this->addSql('ALTER TABLE user DROP worker_user_id');
    }
}
