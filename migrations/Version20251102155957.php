<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251102155957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, club_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, image_fond VARCHAR(255) DEFAULT NULL, INDEX IDX_2449BA1561190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe_rencontre (equipe_id INT NOT NULL, rencontre_id INT NOT NULL, INDEX IDX_1A7D50166D861B89 (equipe_id), INDEX IDX_1A7D50166CFC0818 (rencontre_id), PRIMARY KEY(equipe_id, rencontre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueur (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, bio LONGTEXT NOT NULL, pseudo VARCHAR(255) NOT NULL, INDEX IDX_FD71A9C56D861B89 (equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, jeu VARCHAR(255) NOT NULL, INDEX IDX_6A2CA10C6D861B89 (equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rencontre (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, resultat VARCHAR(255) NOT NULL, jeu VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistique (id INT AUTO_INCREMENT NOT NULL, rencontre_id INT NOT NULL, kill_count INT NOT NULL, dead_count INT NOT NULL, assist_count INT NOT NULL, INDEX IDX_73A038AD6CFC0818 (rencontre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(100) DEFAULT NULL, date_naissance DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, rencontre_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, point INT DEFAULT NULL, INDEX IDX_5A1085646D861B89 (equipe_id), INDEX IDX_5A1085646CFC0818 (rencontre_id), INDEX IDX_5A108564FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1561190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE equipe_rencontre ADD CONSTRAINT FK_1A7D50166D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_rencontre ADD CONSTRAINT FK_1A7D50166CFC0818 FOREIGN KEY (rencontre_id) REFERENCES rencontre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C56D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE statistique ADD CONSTRAINT FK_73A038AD6CFC0818 FOREIGN KEY (rencontre_id) REFERENCES rencontre (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085646D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085646CFC0818 FOREIGN KEY (rencontre_id) REFERENCES rencontre (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1561190A32');
        $this->addSql('ALTER TABLE equipe_rencontre DROP FOREIGN KEY FK_1A7D50166D861B89');
        $this->addSql('ALTER TABLE equipe_rencontre DROP FOREIGN KEY FK_1A7D50166CFC0818');
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C56D861B89');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C6D861B89');
        $this->addSql('ALTER TABLE statistique DROP FOREIGN KEY FK_73A038AD6CFC0818');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085646D861B89');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085646CFC0818');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564FB88E14F');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE equipe_rencontre');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE rencontre');
        $this->addSql('DROP TABLE statistique');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
