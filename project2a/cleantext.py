import re

squeeze_space = re.compile(r'[\t\n ]+')
url_matcher = re.compile(r'https?:\/\/[^)]*')
punctuation_matcher = re.compile(r'([?.,:;!])')
bad_punctuation_matcher = re.compile(r'[^A-Za-z0-9?!.,;: ][^A-Za-z0-9?!.,;:]|[^A-Za-z0-9?!.,;:][^A-Za-z0-9?!.,;: ]')      # is fucked up but is semi-working (doesn't work for the url case)

def sanitize(s):
    #### Parsing

    res = squeeze_space.sub(' ', s)     # 1 squeeze spaces into 1 space (also covers # 3)
    res = url_matcher.sub('', res)      # 2 remove urls
    res = punctuation_matcher.sub(r' \1 ', res) # 4 separate external pucntuation (putting spaces between punctuation we want)
    res = bad_punctuation_matcher.sub(' ', res)  # 5 remove bad punctuation that isn't inside a word
    res = res.lower()                     # 6

    res = squeeze_space.sub(' ', res)

    tokens = res.split(' ')
    n = len(tokens)

    #### Unigrams
    unigram = list(filter(lambda x: x not in ['.', ',', ':', ';', '!', '?'], tokens))
    unigram = ' '.join(unigram)


    #### Bigrams
    bigrams = []
    for i in range(0, n-1): 
        if(punctuation_matcher.match(tokens[i]) is None and punctuation_matcher.match(tokens[i+1]) is None):
            bigrams.append("{}_{}".format(tokens[i], tokens[i+1]))

    bigrams = ' '.join(bigrams)


    #### Trigrams
    trigrams = []
    for i in range(0, n-2): 
        if(punctuation_matcher.match(tokens[i]) is None and punctuation_matcher.match(tokens[i+1]) is None and punctuation_matcher.match(tokens[i+2]) is None):
            trigrams.append("{}_{}_{}".format(tokens[i], tokens[i+1], tokens[i+2]))

    trigrams = ' '.join(trigrams)

    return (res, unigram, bigrams, trigrams)


def format_print(tup):
    for t in tup:
        print(t)


def main():
    # test 1
    format_print(sanitize("I'm afraid I can't explain myself, sir. Because I am not myself, you see?"))
    # test 2
    format_print(sanitize("FUCK [some text](http://facebook.com) this is a url that we need'ed to remove. yaauhklh"))

    # Failed Case 1
    # Should remove the starting and ending closing parenthesis, but does not
    # Fix by adding additional space at start and end?
    format_print(sanitize("(Hello)")) 


if __name__ == "__main__":
    main()