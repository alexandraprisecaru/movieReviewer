<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181217161852 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C679F37AE5');
        $this->addSql('ALTER TABLE review ALTER id_user_id DROP NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C679F37AE5 FOREIGN KEY (id_user_id) REFERENCES user_review (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT fk_794381c679f37ae5');
        $this->addSql('ALTER TABLE review ALTER id_user_id SET NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT fk_794381c679f37ae5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
