<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221203083757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create order table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS public.order
        (
            id character varying COLLATE pg_catalog."default" NOT NULL,
            customer_id character varying COLLATE pg_catalog."default" NOT NULL,
            created_at timestamp without time zone NOT NULL DEFAULT now(),
            CONSTRAINT order_pkey PRIMARY KEY (id)
        )
SQL;
        $this->connection->executeStatement($sql);
    }

    public function down(Schema $schema): void
    {
        $this->connection->executeStatement('DROP TABLE IF EXISTS public.order');
    }
}
