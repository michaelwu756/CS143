import re

squeeze_space = re.compile(r'[\t\n ]+')
url_matcher = re.compile(r'https?:\/\/[^)]*')
punctuation_matcher = re.compile(r'([?.,:;!])')
bad_punctuation_matcher = re.compile(r'[^A-Za-z?!.,;:]\s+|\s+[^A-Za-z?!.,;:]')      # is fucked up but is semi-working (doesn't work for the url case)

def sanitize(s):
    print s
    res = squeeze_space.sub(' ', s)     # 1 squeeze spaces into 1 space (also covers # 3)
    res = url_matcher.sub('', res)      # 2 remove urls
    res = punctuation_matcher.sub(r' \1 ', res) # 4 separate external pucntuation (putting spaces between punctuation we want)
    res = bad_punctuation_matcher.sub(' ', res)  # 5 remove bad punctuation that isn't inside a word
    res = res.lower()                     # 6
    return res



def main():
    # test 1
    print sanitize("I'm afraid I can't explain myself, sir. Because I am not myself, you see?")
    # test 2
    print sanitize("FUCK [some text](http://facebook.com) this is a url that we need'ed to remove. yaauhklh")



if __name__ == "__main__":
    main()