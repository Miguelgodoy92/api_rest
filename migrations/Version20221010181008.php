<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221010181008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP cliente');
        $this->addSql('ALTER TABLE direccion DROP INDEX UNIQ_F384BE9558BC1BE0, ADD INDEX IDX_F384BE9558BC1BE0 (municipio_id)');
        $this->addSql('ALTER TABLE direccion DROP INDEX UNIQ_F384BE954E7121AF, ADD INDEX IDX_F384BE954E7121AF (provincia_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente ADD cliente VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE direccion DROP INDEX IDX_F384BE9558BC1BE0, ADD UNIQUE INDEX UNIQ_F384BE9558BC1BE0 (municipio_id)');
        $this->addSql('ALTER TABLE direccion DROP INDEX IDX_F384BE954E7121AF, ADD UNIQUE INDEX UNIQ_F384BE954E7121AF (provincia_id)');
    }
}
