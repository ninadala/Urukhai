<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923083750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CEA39FCC8');
        $this->addSql('DROP INDEX IDX_4E977E5CEA39FCC8 ON salle');
        $this->addSql('ALTER TABLE salle CHANGE franchise_id_id franchise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5C523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4E977E5C523CAB89 ON salle (franchise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5C523CAB89');
        $this->addSql('DROP INDEX IDX_4E977E5C523CAB89 ON salle');
        $this->addSql('ALTER TABLE salle CHANGE franchise_id franchise_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CEA39FCC8 FOREIGN KEY (franchise_id_id) REFERENCES franchise (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4E977E5CEA39FCC8 ON salle (franchise_id_id)');
    }
}
