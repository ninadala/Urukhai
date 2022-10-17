<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220926072258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change the tables Franchise and Salle';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise DROP email, DROP password');
        $this->addSql('ALTER TABLE salle ADD address VARCHAR(255) NOT NULL, ADD capacity INT DEFAULT NULL, DROP email, DROP password, DROP adress');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise ADD email VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE salle ADD password VARCHAR(255) NOT NULL, ADD adress VARCHAR(255) NOT NULL, DROP capacity, CHANGE address email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP email');
    }
}
