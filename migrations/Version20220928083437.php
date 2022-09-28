<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928083437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, description VARCHAR(255) DEFAULT NULL, activated TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission_salle (permission_id INT NOT NULL, salle_id INT NOT NULL, INDEX IDX_9810132FFED90CCA (permission_id), INDEX IDX_9810132FDC304035 (salle_id), PRIMARY KEY(permission_id, salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission_franchise (permission_id INT NOT NULL, franchise_id INT NOT NULL, INDEX IDX_4401E046FED90CCA (permission_id), INDEX IDX_4401E046523CAB89 (franchise_id), PRIMARY KEY(permission_id, franchise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE permission_salle ADD CONSTRAINT FK_9810132FFED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_salle ADD CONSTRAINT FK_9810132FDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_franchise ADD CONSTRAINT FK_4401E046FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_franchise ADD CONSTRAINT FK_4401E046523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission_salle DROP FOREIGN KEY FK_9810132FFED90CCA');
        $this->addSql('ALTER TABLE permission_salle DROP FOREIGN KEY FK_9810132FDC304035');
        $this->addSql('ALTER TABLE permission_franchise DROP FOREIGN KEY FK_4401E046FED90CCA');
        $this->addSql('ALTER TABLE permission_franchise DROP FOREIGN KEY FK_4401E046523CAB89');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE permission_salle');
        $this->addSql('DROP TABLE permission_franchise');
    }
}
