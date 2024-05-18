<?php

namespace Core\SeedWork\Domain\ValueObjects;

use InvalidArgumentException;

class CnpjVO
{
    public function __construct(
        protected string $value
    ) {
        $this->validate();
    }

    public function validate(): void
    {
        if (! $this->isValidCnpj($this->value)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $this->value));
        }
    }

    private function isValidCnpj(string $cnpj): bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
