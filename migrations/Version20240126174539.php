<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126174539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_ingredient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_ingredient_ingredient (categorie_ingredient_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_1F504B7090F001C6 (categorie_ingredient_id), INDEX IDX_1F504B70933FE08C (ingredient_id), PRIMARY KEY(categorie_ingredient_id, ingredient_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_recette (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_recette_recette (categorie_recette_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_5058CF4417F8E545 (categorie_recette_id), INDEX IDX_5058CF4489312FE9 (recette_id), PRIMARY KEY(categorie_recette_id, recette_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, prix VARCHAR(255) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, lien VARCHAR(255) DEFAULT NULL, INDEX IDX_6BAF7870FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, prix VARCHAR(255) DEFAULT NULL, utilisation VARCHAR(255) DEFAULT NULL, caractéristique VARCHAR(255) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, lien VARCHAR(255) DEFAULT NULL, INDEX IDX_18D2B091FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quantite_ingredient (id INT AUTO_INCREMENT NOT NULL, id_ingredient_id INT DEFAULT NULL, recette_id INT DEFAULT NULL, quantite DOUBLE PRECISION NOT NULL, unite VARCHAR(255) NOT NULL, INDEX IDX_B24201872D1731E9 (id_ingredient_id), INDEX IDX_B242018789312FE9 (recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, titre VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, conseil VARCHAR(255) DEFAULT NULL, duree VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, date_publication DATETIME DEFAULT NULL, INDEX IDX_49BB6390FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette_materiel (recette_id INT NOT NULL, materiel_id INT NOT NULL, INDEX IDX_A8C6506989312FE9 (recette_id), INDEX IDX_A8C6506916880AAF (materiel_id), PRIMARY KEY(recette_id, materiel_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, adresse_email VARCHAR(255) NOT NULL, premium TINYINT(1) DEFAULT 0 NOT NULL, nom VARCHAR(50) DEFAULT NULL, prenom VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B3AA08CB10 (login), UNIQUE INDEX UNIQ_1D1C63B388D20D42 (adresse_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_ingredient_ingredient ADD CONSTRAINT FK_1F504B7090F001C6 FOREIGN KEY (categorie_ingredient_id) REFERENCES categorie_ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_ingredient_ingredient ADD CONSTRAINT FK_1F504B70933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_recette_recette ADD CONSTRAINT FK_5058CF4417F8E545 FOREIGN KEY (categorie_recette_id) REFERENCES categorie_recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_recette_recette ADD CONSTRAINT FK_5058CF4489312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE quantite_ingredient ADD CONSTRAINT FK_B24201872D1731E9 FOREIGN KEY (id_ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE quantite_ingredient ADD CONSTRAINT FK_B242018789312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE recette_materiel ADD CONSTRAINT FK_A8C6506989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_materiel ADD CONSTRAINT FK_A8C6506916880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_ingredient_ingredient DROP FOREIGN KEY FK_1F504B7090F001C6');
        $this->addSql('ALTER TABLE categorie_ingredient_ingredient DROP FOREIGN KEY FK_1F504B70933FE08C');
        $this->addSql('ALTER TABLE categorie_recette_recette DROP FOREIGN KEY FK_5058CF4417F8E545');
        $this->addSql('ALTER TABLE categorie_recette_recette DROP FOREIGN KEY FK_5058CF4489312FE9');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870FB88E14F');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091FB88E14F');
        $this->addSql('ALTER TABLE quantite_ingredient DROP FOREIGN KEY FK_B24201872D1731E9');
        $this->addSql('ALTER TABLE quantite_ingredient DROP FOREIGN KEY FK_B242018789312FE9');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390FB88E14F');
        $this->addSql('ALTER TABLE recette_materiel DROP FOREIGN KEY FK_A8C6506989312FE9');
        $this->addSql('ALTER TABLE recette_materiel DROP FOREIGN KEY FK_A8C6506916880AAF');
        $this->addSql('DROP TABLE categorie_ingredient');
        $this->addSql('DROP TABLE categorie_ingredient_ingredient');
        $this->addSql('DROP TABLE categorie_recette');
        $this->addSql('DROP TABLE categorie_recette_recette');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE quantite_ingredient');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE recette_materiel');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE utilisateur');
    }
}
