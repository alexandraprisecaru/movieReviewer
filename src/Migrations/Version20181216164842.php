<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181216164842 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE actor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE movie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE actor (id INT NOT NULL, first_name VARCHAR(80) NOT NULL, last_name VARCHAR(100) NOT NULL, description VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE actor_movie (actor_id INT NOT NULL, movie_id INT NOT NULL, PRIMARY KEY(actor_id, movie_id))');
        $this->addSql('CREATE INDEX IDX_39DA19FB10DAF24A ON actor_movie (actor_id)');
        $this->addSql('CREATE INDEX IDX_39DA19FB8F93B6FC ON actor_movie (movie_id)');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(250) DEFAULT NULL, year INT NOT NULL, genre VARCHAR(50) DEFAULT NULL, trailer VARCHAR(250) DEFAULT NULL, rating DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE review (id INT NOT NULL, id_user_id INT NOT NULL, id_movie_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, rating INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_794381C679F37AE5 ON review (id_user_id)');
        $this->addSql('CREATE INDEX IDX_794381C6DF485A69 ON review (id_movie_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, id_user VARCHAR(4) DEFAULT NULL, user_name VARCHAR(50) NOT NULL, password VARCHAR(80) NOT NULL, first_name VARCHAR(80) NOT NULL, lastname VARCHAR(80) DEFAULT NULL, role VARCHAR(15) NOT NULL, firstname VARCHAR(80) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE actor_movie ADD CONSTRAINT FK_39DA19FB10DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE actor_movie ADD CONSTRAINT FK_39DA19FB8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C679F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6DF485A69 FOREIGN KEY (id_movie_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE actor_movie DROP CONSTRAINT FK_39DA19FB10DAF24A');
        $this->addSql('ALTER TABLE actor_movie DROP CONSTRAINT FK_39DA19FB8F93B6FC');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C6DF485A69');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C679F37AE5');
        $this->addSql('DROP SEQUENCE actor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE movie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE review_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE actor_movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE "user"');
    }
}
