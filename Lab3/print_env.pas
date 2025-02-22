PROGRAM PrintEnv(INPUT, OUTPUT);
USES 
  DOS;
BEGIN {PrintEnv}
	WRITELN('Content-Type: text/plain');
	WRITELN;
	WRITELN('Method: ', GetEnv('REQUEST_METHOD'));
	WRITELN('Query: ', GetEnv('QUERY_STRING'));
	WRITELN('Content length: ', GetEnv('CONTENT_LENGTH'));
	WRITELN('User-Agent: ', GetEnv('HTTP_USER_AGENT'));
	WRITELN('Host: ', GetEnv('HTTP_HOST'))
END. {PrintEnv}