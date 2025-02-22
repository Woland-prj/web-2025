PROGRAM WorkWithQueryString(INPUT, OUTPUT);
USES
  DOS;
FUNCTION GetQueryStringParameter(Key: STRING): STRING;
VAR
	KeyPos, BorderPos: INTEGER;
	QueryString: STRING;
BEGIN {GetQueryStringParameter}
	QueryString := GetEnv('QUERY_STRING');
	KeyPos := Pos(Key + '=', QueryString);
	IF KeyPos <> 0
	THEN
	  BEGIN
			QueryString := Copy(QueryString, KeyPos + Length(Key) + 1, Length(QueryString) + 1);
			BorderPos := Pos('&', QueryString);
			IF BorderPos <> 0
			THEN
				GetQueryStringParameter := Copy(QueryString, 1, BorderPos - 1)
			ELSE
				GetQueryStringParameter := QueryString
		END
	ELSE
		GetQueryStringParameter := ''
END; {GetQueryStringParameter}
BEGIN {WorkWithQueryString}
	WRITELN('Content-Type: text/plain');
	WRITELN;
  WRITELN('First Name: ', GetQueryStringParameter('first_name'));
  WRITELN('Last Name: ', GetQueryStringParameter('last_name'));
  WRITELN('Age: ', GetQueryStringParameter('age'))
END. {WorkWithQueryString}