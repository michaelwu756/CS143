Our reddit_model.py uses the reddit comment data to generate analytic csv files. There are three intermediate
stages where the work is saved to disk, which can be controlled using the three variables saved_initial_dfs,
saved_trained_models, and predicted_sentiment. If any of these is set to true, the program will attempte to load
the saved data from disk instead of recomputing a given stage. In the first stage we load the data from
the json and csv files, in the second we train our classifiers, and in the third we use our classifiers to
predict on the entire dataset. Finally, the progam runs some SQL queries on the generated predictions and
saves these as csvs to disk. The initial json and csv files should be placed under the same directory as
reddit_model.py in a folder called "./data". The saved models are located in "./models", saved dataframes are
located in "./parquets", and the output csvs are located in "./csv".

Use:

ipython reddit_model.py

Our analysis.py uses the generated data from reddit_model.py and generates the plots for our reports. It requires
the models in "./models" and the test data parquets in "./parquets" to plot the ROC curves for our classifiers.
It uses the csv files in "./csv" to plot how sentiment towards trump varies by state, scatter plots of sentiment
by comment and submission score, and sentiment by time. Note that the required shape files to generate the state maps
are located in "./analysis".

Use:

python3 analysis.py

Extra credit:

We trained classifiers for the Democrat and Republican labels as well. In order to convert the classifier
predictions into binary labels, we had to plot ROC curves for all of our six classifiers and look at where the
true positive rate began decreasing relative to the false positive rate. Note that the democrat classifiers
had very few positive training examples, which is why the ROC curve looks jagged. That is also why our threshold
for the positive democrat classifier is 0.025. Also note that the republican classifiers seemed to do very poorly,
and had relatively low ROC scores. This may be due to the labelled data being poorly classified.

Additionally, we added Hawaii and Alaska onto our maps for extra credit.