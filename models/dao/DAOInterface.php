<?php

interface DAOInterface
{
    public function create(object $object): bool;

    public function read(int $id): ?object;

    public function update(object $object): bool;

    public function delete(int $id): bool;

    public function findAll(): array;

    public function findById(int $id): ?object;
}