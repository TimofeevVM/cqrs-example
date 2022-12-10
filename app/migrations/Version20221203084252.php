<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221203084252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create order_item table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS public.order_item
        (
            id character varying COLLATE pg_catalog."default" NOT NULL,
            product_id character varying COLLATE pg_catalog."default" NOT NULL,
            price numeric NOT NULL,
            quantity numeric NOT NULL,
            discount numeric,
            order_id character varying COLLATE pg_catalog."default" NOT NULL,
            CONSTRAINT order_item_pkey PRIMARY KEY (id)
        )
SQL;
        $this->connection->executeStatement($sql);
    }

    public function down(Schema $schema): void
    {
        $this->connection->executeStatement('DROP TABLE IF EXISTS public.order_item');
    }
}
