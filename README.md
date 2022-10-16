# martiis/uuid-console

This is a console application for generating UUIDs with
[ramsey/uuid][1] and inspired by 
[ramsey/uuid-console][2].

The biggest difference is in the *decode* command which will detect time-ordered UUIDs
and also dump time-ordered value for UUID version 1. I find this useful while working with database clients
because they usually only format values into hex. *Decode* command is not as rich as [ramsey][2],
but it's enough for me.

## Usage

### Generate

Will only generate version "1" and "4".

```
php ./bin/uuid generate
18c68556-4d4f-11ed-b7cd-0242ac120002
```
```
php ./bin/uuid generate -c 3
3b6589cc-4d4f-11ed-85f7-0242ac120002
3b8f1012-4d4f-11ed-90e0-0242ac120002
3b8f133c-4d4f-11ed-a9f0-0242ac120002
```
```
php ./bin/uuid generate 4 -c 2
98721e31-4ab5-4104-ba0f-3b1ce34407f9
2b2b019b-57a8-444a-b2f5-e28aa1d0d45b
```

### Decode

```
php ./bin/uuid decode 3b8f1012-4d4f-11ed-90e0-0242ac120002
 -------------- --------------------------------------
  str            3b8f1012-4d4f-11ed-90e0-0242ac120002
  str-hex        3b8f10124d4f11ed90e00242ac120002
  version        1
  ord-time       0x11ed4d4f3b8f101290e00242ac120002
  encoded time   2022-10-16T12:37:01+00:00
 -------------- --------------------------------------
```

If detects UUID starting with `0x` will decode as time-ordered.

```
php ./bin/uuid decode 0x11ed4d4f3b8f101290e00242ac120002
 -------------- --------------------------------------
  str            3b8f1012-4d4f-11ed-90e0-0242ac120002
  str-hex        3b8f10124d4f11ed90e00242ac120002
  version        1
  ord-time       0x11ed4d4f3b8f101290e00242ac120002
  encoded time   2022-10-16T12:37:01+00:00
 -------------- --------------------------------------
```

[1]: https://github.com/ramsey/uuid
[2]: https://github.com/ramsey/uuid-console
