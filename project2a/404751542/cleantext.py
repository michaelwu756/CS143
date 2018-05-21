#!/usr/bin/env python

"""Clean comment text for easier parsing."""

from __future__ import print_function

import re
import string
import argparse


__author__ = ""
__email__ = ""

# Some useful data.
_CONTRACTIONS = {
    "tis": "'tis",
    "aint": "ain't",
    "amnt": "amn't",
    "arent": "aren't",
    "cant": "can't",
    "couldve": "could've",
    "couldnt": "couldn't",
    "didnt": "didn't",
    "doesnt": "doesn't",
    "dont": "don't",
    "hadnt": "hadn't",
    "hasnt": "hasn't",
    "havent": "haven't",
    "hed": "he'd",
    "hell": "he'll",
    "hes": "he's",
    "howd": "how'd",
    "howll": "how'll",
    "hows": "how's",
    "id": "i'd",
    "ill": "i'll",
    "im": "i'm",
    "ive": "i've",
    "isnt": "isn't",
    "itd": "it'd",
    "itll": "it'll",
    "its": "it's",
    "mightnt": "mightn't",
    "mightve": "might've",
    "mustnt": "mustn't",
    "mustve": "must've",
    "neednt": "needn't",
    "oclock": "o'clock",
    "ol": "'ol",
    "oughtnt": "oughtn't",
    "shant": "shan't",
    "shed": "she'd",
    "shell": "she'll",
    "shes": "she's",
    "shouldve": "should've",
    "shouldnt": "shouldn't",
    "somebodys": "somebody's",
    "someones": "someone's",
    "somethings": "something's",
    "thatll": "that'll",
    "thats": "that's",
    "thatd": "that'd",
    "thered": "there'd",
    "therere": "there're",
    "theres": "there's",
    "theyd": "they'd",
    "theyll": "they'll",
    "theyre": "they're",
    "theyve": "they've",
    "wasnt": "wasn't",
    "wed": "we'd",
    "wedve": "wed've",
    "well": "we'll",
    "were": "we're",
    "weve": "we've",
    "werent": "weren't",
    "whatd": "what'd",
    "whatll": "what'll",
    "whatre": "what're",
    "whats": "what's",
    "whatve": "what've",
    "whens": "when's",
    "whered": "where'd",
    "wheres": "where's",
    "whereve": "where've",
    "whod": "who'd",
    "whodve": "whod've",
    "wholl": "who'll",
    "whore": "who're",
    "whos": "who's",
    "whove": "who've",
    "whyd": "why'd",
    "whyre": "why're",
    "whys": "why's",
    "wont": "won't",
    "wouldve": "would've",
    "wouldnt": "wouldn't",
    "yall": "y'all",
    "youd": "you'd",
    "youll": "you'll",
    "youre": "you're",
    "youve": "you've"
}

# You may need to write regular expressions.


squeeze_space = re.compile(r'[\t\n ]+')
url_matcher = re.compile(r'https?:\/\/[^ ]*|www.[^ ]*')
punctuation_matcher = re.compile(r'([?.,:;!])')
bad_punctuation_matcher = re.compile(r"[^A-Za-z0-9?!.,;: ][^A-Za-z0-9?!.,;:]|[^A-Za-z0-9?!.,;:][^A-Za-z0-9?!.,;: ]")      # is fucked up but is semi-working

def space_valid_punctuations(text):
    res = ""
    i = 0
    while i < len(text):
        if ((res == "" or res[len(res) - 1] == ' ') and
            ord(text[i]) not in range(ord('a'), ord('z')) and
            ord(text[i]) not in range(ord('A'), ord('Z')) and
            ord(text[i]) not in range(ord('0'), ord('9')) and
            text[i] != "'" and
            text[i] != " "):
                if (text[i] == "?" or
                    text[i] == "!" or
                    text[i] == "." or
                    text[i] == "," or
                    text[i] == ";" or
                    text[i] == ":"):
                        print('a--')
                        res = res + text[i] + " "
                print('b--')
        else:
            print('c--')
            res = res + text[i]
        print(str(i) + res + text[i])
        i = i + 1
    rev = res[::-1]
    res = ""
    i = 0
    while i < len(rev):
        if ((res == "" or res[len(res) - 1] == ' ') and
            ord(rev[i]) not in range(ord('a'), ord('z')) and
            ord(rev[i]) not in range(ord('A'), ord('Z')) and
            ord(rev[i]) not in range(ord('0'), ord('9')) and
            rev[i] != "'" and
            rev[i] != " "):
                if (rev[i] == "?" or
                    rev[i] == "!" or
                    rev[i] == "." or
                    rev[i] == "," or
                    rev[i] == ";" or
                    rev[i] == ":"):
                        res = res + rev[i] + " "
        else:
            res = res + rev[i]
        print(res + rev[i])
        i = i + 1
    return res[::-1]

def sanitize(text):
    """Do parse the text in variable "text" according to the spec, and return
    a LIST containing FOUR strings 
    1. The parsed text.
    2. The unigrams
    3. The bigrams
    4. The trigrams
    """

    # YOUR CODE GOES BELOW:



    ###$ PARSING TEXT


    # 1 squeeze spaces into 1 space (also covers # 3)
    parsed_text = squeeze_space.sub(' ', text)     

    # 2 remove urls
    parsed_text = url_matcher.sub('', parsed_text)      

    # 4 separate external pucntuation (putting spaces between punctuation we want)
    parsed_text = space_valid_punctuations(parsed_text)
    print("RESULT OF PROCEDURAL CODE" + parsed_text)

    # 5 remove bad punctuation that isn't inside a word and isn't a contraction
    temp_tokens = parsed_text.split(' ')
    i = 0
    while i < len(temp_tokens):
        t = " " + temp_tokens[i] + " "
        print(bad_punctuation_matcher.match(t))
        if bad_punctuation_matcher.match(t) and t not in _CONTRACTIONS.values():
            temp_tokens[i] = bad_punctuation_matcher.sub(' ', t)
            continue
        i += 1
    parsed_text = ' '.join(temp_tokens)


    # parsed_text = bad_punctuation_matcher.sub(' ', parsed_text)  # 5 remove bad punctuation that isn't inside a word
    parsed_text = parsed_text.lower()                     # 6

    # squeeze spaces again and strip leading and ending spaces
    parsed_text = squeeze_space.sub(' ', parsed_text).strip()


    tokens = parsed_text.split(' ')
    tokens = list(filter(None, tokens))
    n = len(tokens)

    #### Unigrams
    unigrams = list(filter(lambda x: x not in ['.', ',', ':', ';', '!', '?'], tokens))
    unigrams = ' '.join(unigrams)


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

    return [parsed_text, unigrams, bigrams, trigrams]

# For testing only
def format_print(tup):
    for t in tup:
        print(t)

if __name__ == "__main__":
    # This is the Python main function.
    # You should be able to run
    # python cleantext.py <filename>
    # and this "main" function will open the file,
    # read it line by line, extract the proper value from the JSON,
    # pass to "sanitize" and print the result as a list.

    # YOUR CODE GOES BELOW.

    # For testing
    try:
        while 1:
            format_print(sanitize(input("Try input...: ")))
    except(KeyboardInterrupt):
        print("exiting...")

