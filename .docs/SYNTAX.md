# DataQL -> Syntax

## Selecting
```
photos
photos{id,filename,created_at,updated_at}
```

## Limiting
```
photos<10>
photos<20,10>
```

## Ordering
```
photos[>id]
photos[>created_at,<id]
```

## Filtering
```
photos(id>10)
photos(id<10)
photos(id<=10)
photos(id>=10)
photos(id=10)
photos(id!=10)
photos(id=null)
photos(id!=null)
photos(filename%=yoda)
photos(filename=%yoda)
photos(filename%=%yoda)
photos(filename*%=%yoda)
photos(id=[1,2,3])
photos(id!=[1,2,3])
photos(filename="")
photos(filename!="")
```

## Full

```
photos(id>1000)<0,10>[>created_at]{filename}
```

## Nested

```
photos{filename, author{firsname,surname}}
photos{filename, category(author=Felix)[>id]{name}}
```
