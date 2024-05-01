<?php

function validaNome(string $nome): string
{
    /** @var  $padrao
     * No mínimo 5 caracteres
     * No máximo 15 caracteres
     * Apenas alfanumérico
     */
    $padrao = "/^([a-z0-9]\s?){5,15}$/i";

    return preg_match($padrao, $nome);
}

function validaSenha(string $nome): string
{
    /** @var  $padrao
     *  Expressão regular que valida:
     *  No mínimo 6 caracteres
     *  No máximo 20 caracteresspecial(!#@$%&)
     *  No mínimo uma letra maiúscula
     *  No mínimo um caractere numérico
     *  No mínimo um caractere especial
     */
    $padrao = "/^(?=.*[A-Z])(?=.*[!#@$%&])(?=.*[0-9])(?=.*[a-z]).{6,15}$/";

    return preg_match($padrao, $nome);
}
