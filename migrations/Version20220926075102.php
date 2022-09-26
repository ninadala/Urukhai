<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220926075102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE franchise ADD CONSTRAINT FK_66F6CE2AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_66F6CE2AA76ED395 ON franchise (user_id)');
        $this->addSql('ALTER TABLE salle ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4E977E5CA76ED395 ON salle (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise DROP FOREIGN KEY FK_66F6CE2AA76ED395');
        $this->addSql('DROP INDEX IDX_66F6CE2AA76ED395 ON franchise');
        $this->addSql('ALTER TABLE franchise DROP user_id');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CA76ED395');
        $this->addSql('DROP INDEX IDX_4E977E5CA76ED395 ON salle');
        $this->addSql('ALTER TABLE salle DROP user_id');
    }
}
