# Infix parsing algorithm concept

I have (probably re-)invented this parsing algorithm that seems pretty natural.

When you naturaly "parse" infix in your head, you try to find expression with highest priority and evaluate it. But when you try to construct syntax tree, you want operations with higher priority to be more nested in the tree. Other fact that this algorithm uses is that every infix expression is in this format `expr operator expr`. So the concept was to find first operator with smallest possible value and use it as most-outer node, take left and right side and repeat the process. This algorithm seems more natural than something like shunting yard algorithm and more aproachable in languages like haskell, because it uses recursion.

But what about brackets? Expression in bracket has highest priority, so while finding operator with lowest priority, you just need to ignore expressions in brackets.

Great thing about this algorihm is, that you can add new operators with higher priority really easilly.

First experimental implementation was done in PHP.

I guess that aprox. time complexity is $O(n log_2(n))$, but I'm not 100% sure.
