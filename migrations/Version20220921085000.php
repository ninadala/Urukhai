<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921085000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5C24729F0A');
        $this->addSql('DROP INDEX IDX_4E977E5C24729F0A ON salle');
        $this->addSql('ALTER TABLE salle CHANGE franchise_name_id franchise_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CEA39FCC8 FOREIGN KEY (franchise_id_id) REFERENCES franchise (id)');
        $this->addSql('CREATE INDEX IDX_4E977E5CEA39FCC8 ON salle (franchise_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CEA39FCC8');
        $this->addSql('DROP INDEX IDX_4E977E5CEA39FCC8 ON salle');
        $this->addSql('ALTER TABLE salle CHANGE franchise_id_id franchise_name_id INT NOT NULL');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5C24729F0A FOREIGN KEY (franchise_name_id) REFERENCES franchise (id)');
        $this->addSql('CREATE INDEX IDX_4E977E5C24729F0A ON salle (franchise_name_id)');
    }
}
