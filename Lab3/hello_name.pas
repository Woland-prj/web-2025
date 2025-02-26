PROGRAM HelloName(INPUT, OUTPUT);
USES
	DOS;
VAR
	QueryString, Name: STRING;
	DivPos: INTEGER;
BEGIN {HelloName}
	WRITELN('Content-Type: text/plain');
	WRITELN;
	QueryString := GetEnv('QUERY_STRING');
	DivPos := Pos('=', QueryString);
	Name := '';
	IF Copy(QueryString, 1, DivPos - 1) = 'name' 
	THEN 
	  Name := Copy(QueryString, DivPos + 1, Length(QueryString) + 1);
	IF Name <> ''
	THEN
		WRITELN('Hello dear, ', Name, '!')
	ELSE
		WRITELN('Hello, Anonymous!')
END. {HelloName}