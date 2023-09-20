<?php

define('OPERATORS', [
    '+' => 0,
    '-' => 0,
    '*' => 1,
    '/' => 1, 
]);

define('BRACKETS', [
    '(' => 2,
]);

define('MAX_PRIORITY', 3);

function slice(array $tokens, int $at): array
{
    $result = [[], []];
    foreach ($tokens as $index => $token) {
        if ($index < $at) {
            $result[0][] = $token;
        }

        if ($index > $at) {
            $result[1][] = $token;
        }
    }

    return $result;
}

/**
 * @param array<PhpToken> $tokens
 */
function parse(array $tokens): array
{
    if (count($tokens) == 1) {
        if (!$tokens[0]->is(T_LNUMBER)) {
            throw new Exception('unexpected token');
        }

        return [
            'type' => 'number',
            'value' => $tokens[0]->text,
        ];
    }
    $level = 2;
    $op = 0;
    $curent_priority = MAX_PRIORITY;
    $brackets = 0; 
    foreach ($tokens as $index => $token) {
        if ($token->is('(')) {
            unset($tokens[$index]);
            $brackets++;
            $curent_priority = 2;
            continue;
        }

        if ($token->is(')')) {
            unset($tokens[$index]);
            $brackets--;
            continue;
        }

        if ($brackets !== 0) {
            continue;
        }
        
        $curent_priority = OPERATORS[$token->text] ?? null;
        
        if ($curent_priority === NULL) {
            continue;
        }

        if ($curent_priority < $level) {
            $level = $curent_priority;
            $op = $index;
        }
    }

    [$left, $right] = slice($tokens, $op);

    return [
        'type' => 'operator',
        'value' => $tokens[$op]->text,
        'left' => parse($left),
        'right' => parse($right),
    ];
}

print_r(parse(array_values(array_slice(PhpToken::tokenize('<?php (1+1)*(1+2)'), 1))));
