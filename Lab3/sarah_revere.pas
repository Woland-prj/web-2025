PROGRAM WebSarahRevere(INPUT, OUTPUT);
USES
	DOS;
VAR
	RetStr: STRING;
PROCEDURE SarahRevere(Lanterns: STRING; VAR RetStr: STRING);
BEGIN {SarahRevere}
	RetStr := 'The British are coming by ';
  IF Lanterns = 'lanterns=1' 
	THEN
		RetStr := RetStr + 'land.'
	ELSE
	  IF Lanterns = 'lanterns=2' 
		THEN
			RetStr := RetStr + 'sea.'
		ELSE
			RetStr := 'Sarah didn''t say.'
END;  {SarahRevere}
BEGIN {WebSarahRevere}
	WRITELN('Content-Type: text/plain');
	WRITELN;
	SarahRevere(GetEnv('QUERY_STRING'), RetStr);
	WRITELN(RetStr)
END.  {WebSarahRevere}