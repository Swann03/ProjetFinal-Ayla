<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251023154749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueur (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, bio VARCHAR(255) NOT NULL, INDEX IDX_FD71A9C56D861B89 (equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, jeu VARCHAR(255) NOT NULL, INDEX IDX_6A2CA10C6D861B89 (equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rencontre (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, resultat VARCHAR(255) NOT NULL, jeu VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rencontre_equipe (rencontre_id INT NOT NULL, equipe_id INT NOT NULL, INDEX IDX_9035E6BF6CFC0818 (rencontre_id), INDEX IDX_9035E6BF6D861B89 (equipe_id), PRIMARY KEY(rencontre_id, equipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistique (id INT AUTO_INCREMENT NOT NULL, rencontre_id INT NOT NULL, kill_count INT NOT NULL, dead_count INT NOT NULL, assist_count INT NOT NULL, INDEX IDX_73A038AD6CFC0818 (rencontre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(100) DEFAULT NULL, date_naissance DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, rencontre_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, point INT DEFAULT NULL, INDEX IDX_5A1085646D861B89 (equipe_id), INDEX IDX_5A1085646CFC0818 (rencontre_id), INDEX IDX_5A108564FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C56D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE rencontre_equipe ADD CONSTRAINT FK_9035E6BF6CFC0818 FOREIGN KEY (rencontre_id) REFERENCES rencontre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rencontre_equipe ADD CONSTRAINT FK_9035E6BF6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE statistique ADD CONSTRAINT FK_73A038AD6CFC0818 FOREIGN KEY (rencontre_id) REFERENCES rencontre (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085646D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085646CFC0818 FOREIGN KEY (rencontre_id) REFERENCES rencontre (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C56D861B89');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C6D861B89');
        $this->addSql('ALTER TABLE rencontre_equipe DROP FOREIGN KEY FK_9035E6BF6CFC0818');
        $this->addSql('ALTER TABLE rencontre_equipe DROP FOREIGN KEY FK_9035E6BF6D861B89');
        $this->addSql('ALTER TABLE statistique DROP FOREIGN KEY FK_73A038AD6CFC0818');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085646D861B89');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085646CFC0818');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564FB88E14F');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE rencontre');
        $this->addSql('DROP TABLE rencontre_equipe');
        $this->addSql('DROP TABLE statistique');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
