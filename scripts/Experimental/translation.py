import requests
import json
import sys

try:
	try:
		args = sys.argv
		from_lang = args[1]
		to_lang = args[2]
		txt = args[3]
		url = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20130809T102502Z.f7a7751a64de631f.c394ca92e5549a30a9ae4922051d1f26b8a8d6a1&lang=" + from_lang + "-" + to_lang + "&text=" + txt
		r = requests.get(url)
		json_translation = json.loads(r.text)
		if json_translation["code"] != 200:
			print "Error in connection or authentication. Retry"
		translated_text = json.dumps(json_translation["text"])[2:-2]
		print translated_text
	except IndexError:
			print "*Script failed. Script should be executed: translation.py from_lang to_lang txt_to_translate \n *E.g. python translation.py en fr Hello \n *responds 'Bonjour'"
except NameError:
	print "*Script failed. Script should be executed: translation.py from_lang to_lang txt_to_translate \n *E.g. python translation.py en fr Hello \n *responds 'Bonjour'"