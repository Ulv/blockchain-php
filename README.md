# PHP blockchain

## Add transaction

```
> php add_tx.php ...options...
```

Usage:

```
Add transaction to blockchain

Usage: add_tx.php [-d data, --data data (default: )] [-f from, --from from] [-t to, --to to] [-v value, --value value]

Required Arguments:
        -f from, --from from
                Transfer from
        -t to, --to to
                Transfer to
        -v value, --value value
                Value (amount)

Optional Arguments:
        -d data, --data data (default: )
                Data (accepts only values "" or "reward")
```

## View blockchain

```
> php view_blockchain.php
```
