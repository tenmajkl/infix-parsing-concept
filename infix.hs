-- implementation of the same algorithm in haskell 
-- doesnt support brackets at the moment tbd

data Token = 
    Number Int
    | Operator Char
    deriving Eq

data AST = 
    NumberNode Int
    | Operation Char AST AST
    deriving Show

priority :: Token -> Int
priority (Number _) = 2
priority (Operator '+') = 0
priority (Operator '-') = 0
priority (Operator '*') = 1
priority (Operator '/') = 1
priority (Operator _) = 2

op :: [Token] -> Token
op (x:xs) = if priority x < priority (op xs) then x else op xs
op [] = Number 0

parse :: [Token] -> AST
parse [Number x] = NumberNode x
parse x = let 
    (left, right) = span (/= op x) x 
    (Operator o) = head right
    in Operation o (parse left) (parse $ tail right)

main = print (parse [Number 2, Operator '+', Number 1, Operator '*', Number 3])
