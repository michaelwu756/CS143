# May first need:
# In your VM: sudo apt-get install libgeos-dev (brew install on Mac)
# pip3 install https://github.com/matplotlib/basemap/archive/v1.1.0.tar.gz

import matplotlib
matplotlib.use("Agg")
import matplotlib.pyplot as plt
import pandas as pd
import datetime
import numpy as np
import os

from mpl_toolkits.basemap import Basemap as Basemap
from matplotlib.colors import rgb2hex
from matplotlib.patches import Polygon

"""
IMPORTANT
This is EXAMPLE code.
There are a few things missing:
1) You may need to play with the colors in the US map.
2) This code assumes you are running in Jupyter Notebook or on your own system.
   If you are using the VM, you will instead need to play with writing the images
   to PNG files with decent margins and sizes.
3) The US map only has code for the Positive case. I leave the negative case to you.
4) Alaska and Hawaii got dropped off the map, but it's late, and I want you to have this
   code. So, if you can fix Hawaii and Alask, ExTrA CrEdIt. The source contains info
   about adding them back.
"""
script_dir = os.path.dirname(__file__)
models_dir = "models/"
parquet_dir = "parquets/"
png_dir = "png/"

if not os.path.isdir(os.path.join(script_dir, png_dir)):
  os.makedirs(os.path.join(script_dir, png_dir))

def find_csv(dirname):
  folder = os.path.join(script_dir, "csv", dirname)
  for file in os.listdir(folder):
    if file.endswith(".csv"):
      return os.path.join(folder, file)
"""
PLOT 1: SENTIMENT OVER TIME (TIME SERIES PLOT)
"""
# Assumes a file called time_data.csv that has columns
# date, Positive, Negative. Use absolute path.
filename = find_csv("time_data.csv")

ts = pd.read_csv(filename)
# Remove erroneous row.
ts = ts[ts['date'] != '2018-12-31']

plt.figure(figsize=(12,5))
ts.date = pd.to_datetime(ts['date'], format='%Y-%m-%d')
ts.set_index(['date'],inplace=True)

ax = ts.plot(title="Sentiments on /r/politics Over Time",
        color=['green', 'red', 'blue', 'purple', 'orange', 'grey'],
       ylim=(0, 1.05))
ax.plot()
plt.savefig(os.path.join(script_dir, "png/plot1_sentiment_over_time.png"))
plt.clf()

"""
PLOT 2: SENTIMENT BY STATE (POSITIVE AND NEGATIVE SEPARATELY)
# This example only shows positive, I will leave negative to you.
"""

# This assumes you have a CSV file called "state_data.csv" with the columns:
# state, Positive, Negative
#
# You should use the FULL PATH to the file, just in case.

filename = find_csv("state_data.csv")

state_data = pd.read_csv(filename)

"""
You also need to download the following files. Put them somewhere convenient:
https://github.com/matplotlib/basemap/blob/master/examples/st99_d00.shp
https://github.com/matplotlib/basemap/blob/master/examples/st99_d00.dbf
https://github.com/matplotlib/basemap/blob/master/examples/st99_d00.shx

IF YOU USE WGET (CONVERT TO CURL IF YOU USE THAT) TO DOWNLOAD THE ABOVE FILES, YOU NEED TO USE 
wget "https://github.com/matplotlib/basemap/blob/master/examples/st99_d00.shp?raw=true"
wget "https://github.com/matplotlib/basemap/blob/master/examples/st99_d00.dbf?raw=true"
wget "https://github.com/matplotlib/basemap/blob/master/examples/st99_d00.shx?raw=true"

The rename the files to get rid of the ?raw=true

"""

# Lambert Conformal map of lower 48 states.
m = Basemap(llcrnrlon=-119, llcrnrlat=22, urcrnrlon=-64, urcrnrlat=49,
        projection='lcc', lat_1=33, lat_2=45, lon_0=-95)

# Mercator projection, for Alaska and Hawaii
m_ = Basemap(llcrnrlon=-190,llcrnrlat=20,urcrnrlon=-143,urcrnrlat=46,
            projection='merc',lat_ts=20)  # do not change these numbers

shp_info = m.readshapefile('analysis/state_files/st99_d00','states',drawbounds=True)  # No extension specified in path here.
shp_info_ = m_.readshapefile('analysis/state_files/st99_d00','states',drawbounds=True)

pos_data = dict(zip(state_data.state, state_data.Positive))
neg_data = dict(zip(state_data.state, state_data.Negative))

# choose a color for each state based on sentiment.
statenames = []

pos_cmap = plt.cm.Greens_r # use 'hot' colormap
neg_cmap = plt.cm.Greens_r # use 'hot' colormap
difference_cmap = plt.cm.Greens_r # use 'hot' colormap

# Initialize shape map
for shapedict in m.states_info:
    statename = shapedict['NAME']
    statenames.append(statename)

# Add color to map
def color_state_map(data, cmap):
  # Weighted
  vmin = min(data.items(), key=lambda k: k[1])[1] - 0.01
  vmax = max(data.items(), key=lambda k: k[1])[1]

  colors = {}
  for statename in statenames:
    if statename in data and statename not in ['District of Columbia', 'Puerto Rico']:
      value = data[statename]
      colors[statename] = cmap(1. - np.sqrt(( value - vmin )/( vmax - vmin)))[:3]
    else:
      colors[statename] = cmap(vmin)[:3]

  return colors

pos_colors = color_state_map(pos_data, pos_cmap)
neg_colors = color_state_map(neg_data, neg_cmap)

# Create difference dictionary
difference_data = {}
for state in pos_data:
  if state in neg_data:
    difference_data[state] = pos_data[state] - neg_data[state]

difference_colors = color_state_map(difference_data, difference_cmap)

# POSITIVE MAP

def create_map(colors, cmap, title, filename):
  ax = plt.gca() # get current axes instance

  for nshape, seg in enumerate(m.states):
      # skip Puerto Rico and DC
      if statenames[nshape] not in ['District of Columbia', 'Puerto Rico']:
          color = rgb2hex(colors[statenames[nshape]]) 
          poly = Polygon(seg, facecolor=color, edgecolor=color)
          ax.add_patch(poly)

  AREA_1 = 0.005  # exclude small Hawaiian islands that are smaller than AREA_1
  AREA_2 = AREA_1 * 30.0  # exclude Alaskan islands that are smaller than AREA_2
  AK_SCALE = 0.19  # scale down Alaska to show as a map inset
  HI_OFFSET_X = -1900000  # X coordinate offset amount to move Hawaii "beneath" Texas
  HI_OFFSET_Y = 250000    # similar to above: Y offset for Hawaii
  AK_OFFSET_X = -250000   # X offset for Alaska (These four values are obtained
  AK_OFFSET_Y = -750000   # via manual trial and error, thus changing them is not recommended.)

  for nshape, shapedict in enumerate(m_.states_info):  # plot Alaska and Hawaii as map insets
    if shapedict['NAME'] in ['Alaska', 'Hawaii']:
        seg = m_.states[int(shapedict['SHAPENUM'] - 1)]
        if shapedict['NAME'] == 'Hawaii' and float(shapedict['AREA']) > AREA_1:
            seg = [(x + HI_OFFSET_X, y + HI_OFFSET_Y) for x, y in seg]
            color = rgb2hex(colors[statenames[nshape]])
        elif shapedict['NAME'] == 'Alaska' and float(shapedict['AREA']) > AREA_2:
            seg = [(x*AK_SCALE + AK_OFFSET_X, y*AK_SCALE + AK_OFFSET_Y)\
                   for x, y in seg]
            color = rgb2hex(colors[statenames[nshape]])
        poly = Polygon(seg, facecolor=color, edgecolor=color, linewidth=.5)      
        ax.add_patch(poly)

  #%% ---------  Plot bounding boxes for Alaska and Hawaii insets  --------------
  light_gray = [0.8]*3  # define light gray color RGB
  x1,y1 = m_([-190,-183,-180,-180,-175,-171,-171],[29,29,26,26,26,22,20])
  x2,y2 = m_([-180,-180,-177],[26,23,20])  # these numbers are fine-tuned manually
  m_.plot(x1,y1,color=light_gray,linewidth=0.8)  # do not change them drastically
  m_.plot(x2,y2,color=light_gray,linewidth=0.8)

  plt.title(title)
  plt.savefig(filename)


create_map(pos_colors, pos_cmap, "Positive Trump Sentiment Across the US", os.path.join(script_dir, "png/plot2_positive_by_state.png"))
create_map(neg_colors, neg_cmap, "Negative Trump Sentiment Across the US", os.path.join(script_dir, "png/plot2_negative_by_state.png"))


"""
PLOT 3: SENTIMENT DIFFERENCE BY STATE
"""

create_map(difference_colors, difference_cmap, "Net difference in Trump Sentiment Across the US", os.path.join(script_dir, "png/plot3_difference_by_state.png"))



# SOURCE: https://stackoverflow.com/questions/39742305/how-to-use-basemap-python-to-plot-us-with-50-states
# (this misses Alaska and Hawaii. If you can get them to work, EXTRA CREDIT)

"""
PART 4 SHOULD BE DONE IN SPARK
"""

"""
PLOT 5A: SENTIMENT BY STORY SCORE
"""
# What is the purpose of this? It helps us determine if the story score
# should be a feature in the model. Remember that /r/politics is pretty
# biased.

# Assumes a CSV file called submission_score.csv with the following coluns
# submission_score, Positive, Negative

filename = find_csv("submission_score.csv")

story = pd.read_csv(filename)
plt.figure(figsize=(12,5))
fig = plt.figure()
ax1 = fig.add_subplot(111)

ax1.scatter(story['submission_score'], story['Positive'], s=10, c='b', marker="s", label='Positive')
ax1.scatter(story['submission_score'], story['Negative'], s=10, c='r', marker="o", label='Negative')
plt.legend(loc='lower right');
plt.xlabel('Submission Score')
plt.ylabel("Percent Sentiment")
plt.title("President Trump Sentiment by Submission Score")
plt.savefig(os.path.join(script_dir, "png/plot5a_djt_sentiment_by_story.png"))

ax1.cla()
ax1.scatter(story['submission_score'], story['DemPositive'], s=10, c='b', marker="s", label='Positive')
ax1.scatter(story['submission_score'], story['DemNegative'], s=10, c='r', marker="o", label='Negative')
plt.legend(loc='lower right');
plt.xlabel('Submission Score')
plt.ylabel("Percent Sentiment")
plt.title("Democrat Sentiment by Submission Score")
plt.savefig(os.path.join(script_dir, "png/plot5a_dem_sentiment_by_story.png"))

ax1.cla()
ax1.scatter(story['submission_score'], story['RepPositive'], s=10, c='b', marker="s", label='Positive')
ax1.scatter(story['submission_score'], story['RepNegative'], s=10, c='r', marker="o", label='Negative')
plt.legend(loc='lower right');
plt.xlabel('Submission Score')
plt.ylabel("Percent Sentiment")
plt.title("Republican Sentiment by Submission Score")
plt.savefig(os.path.join(script_dir, "png/plot5a_rep_sentiment_by_story.png"))

"""
PLOT 5B: SENTIMENT BY COMMENT SCORE
"""
# What is the purpose of this? It helps us determine if the comment score
# should be a feature in the model. Remember that /r/politics is pretty
# biased.

# Assumes a CSV file called comment_score.csv with the following columns
# comment_score, Positive, Negative
filename = find_csv("comment_score.csv")
story = pd.read_csv(filename)

plt.figure(figsize=(12,5))
fig = plt.figure()
ax1 = fig.add_subplot(111)
ax = plt.gca()
ax.set_xlim([0,2000])

ax1.scatter(story['comment_score'], story['Positive'], s=10, c='b', marker="s", label='Positive')
ax1.scatter(story['comment_score'], story['Negative'], s=10, c='r', marker="o", label='Negative')

plt.legend(loc='lower right');

plt.xlabel('Comment Score')
plt.ylabel("Percent Sentiment")
plt.title("President Trump Sentiment by Comment Score")
plt.savefig(os.path.join(script_dir, "png/plot5b_djt_sentiment_by_comment.png"))

ax1.cla()
ax.set_xlim([0,2000])
ax1.scatter(story['comment_score'], story['DemPositive'], s=10, c='b', marker="s", label='Positive')
ax1.scatter(story['comment_score'], story['DemNegative'], s=10, c='r', marker="o", label='Negative')

plt.legend(loc='lower right');

plt.xlabel('Comment Score')
plt.ylabel("Percent Sentiment")
plt.title('Democrat Sentiment by Comment Score')
plt.savefig(os.path.join(script_dir, "png/plot5b_dem_sentiment_by_comment.png"))

ax1.cla()
ax.set_xlim([0,2000])
ax1.scatter(story['comment_score'], story['RepPositive'], s=10, c='b', marker="s", label='Positive')
ax1.scatter(story['comment_score'], story['RepNegative'], s=10, c='r', marker="o", label='Negative')

plt.legend(loc='lower right');

plt.xlabel('Comment Score')
plt.ylabel("Percent Sentiment")
plt.title('Republican Sentiment by Comment Score')
plt.savefig(os.path.join(script_dir, "png/plot5b_rep_sentiment_by_comment.png"))

"""
EXTRA CREDIT: TBD
"""

from pyspark import SparkConf, SparkContext
from pyspark.sql import SQLContext
from pyspark.ml.tuning import CrossValidatorModel
from pyspark.mllib.evaluation import BinaryClassificationMetrics

try:
  from sklearn.metrics import roc_curve, auc
except:
  print('No sklearn installed, no ROC curve generated')

conf = SparkConf().setAppName("CS143 Project 2B")
conf = conf.setMaster("local[*]")
sc = SparkContext(conf=conf)
context = SQLContext(sc)

def plot_roc(model, test_data, name, label_col):

  transformed = model.transform(test_data)
  results = transformed.select(["probability", label_col])
  results_collect = results.collect()
  results_list = [(float(i[0][1]), float(i[1])) for i in results_collect]
  score_and_labels = sc.parallelize(results_list)

  metrics = BinaryClassificationMetrics(score_and_labels)
  print("The ROC score for " + name + " is : ", metrics.areaUnderROC)

  y_test = [i[1] for i in results_list]
  y_score = [i[0] for i in results_list]

  fpr, tpr, thresholds = roc_curve(y_test, y_score)
  roc_auc = auc(fpr, tpr)
  for fp, tp, thresh in zip(fpr, tpr, thresholds):
      print("fpr: ", fp, " tpr: ", tp, " threshold: ", thresh)

  plt.clf()
  plt.figure()
  plt.plot(fpr, tpr, label="ROC curve (area = %0.2f)" % roc_auc)
  plt.plot([0, 1], [0, 1], "k--")
  plt.xlim([0.0, 1.0])
  plt.ylim([0.0, 1.05])
  plt.xlabel("False Positive Rate")
  plt.ylabel("True Positive Rate")
  plt.title("Receiver operating characteristic for " + name)
  plt.legend(loc="lower right")
  if not os.path.isdir(os.path.join(script_dir, png_dir)):
      os.makedirs(os.path.join(script_dir, png_dir))
  plt.savefig(os.path.join(script_dir, png_dir + name.replace(" ", "") + ".png"))


try: 
  pos_model = CrossValidatorModel.load(models_dir + "pos.model")
  neg_model = CrossValidatorModel.load(models_dir + "neg.model")
  dem_pos_model = CrossValidatorModel.load(models_dir + "dem_pos.model")
  dem_neg_model = CrossValidatorModel.load(models_dir + "dem_neg.model")
  rep_pos_model = CrossValidatorModel.load(models_dir + "rep_pos.model")
  rep_neg_model = CrossValidatorModel.load(models_dir + "rep_neg.model")

  # load testing data
  pos_test = context.read.parquet(os.path.join(script_dir, parquet_dir + "pos_test.parquet"))
  neg_test = context.read.parquet(os.path.join(script_dir, parquet_dir + "neg_test.parquet"))
  dem_pos_test = context.read.parquet(os.path.join(script_dir, parquet_dir + "dem_pos_test.parquet"))
  dem_neg_test = context.read.parquet(os.path.join(script_dir, parquet_dir + "dem_neg_test.parquet"))
  rep_pos_test = context.read.parquet(os.path.join(script_dir, parquet_dir + "rep_pos_test.parquet"))
  rep_neg_test = context.read.parquet(os.path.join(script_dir, parquet_dir + "rep_neg_test.parquet"))

  print("Making positive ROC plot...")
  plot_roc(pos_model, pos_test, "Trump Positive Classifier", label_col="trump_pos")
  print("Making negative ROC plot...")
  plot_roc(neg_model, neg_test, "Trump Negative Classifier", label_col="trump_neg")
  print("Making democrat positive ROC plot...")
  plot_roc(dem_pos_model, dem_pos_test, "Democrat Positive Classifier", label_col="dem_pos")
  print("Making democrat negative ROC plot...")
  plot_roc(dem_neg_model, dem_neg_test, "Democrat Negative Classifier", label_col="dem_neg")
  print("Making republican positive ROC plot...")
  plot_roc(rep_pos_model, rep_pos_test, "Republican Positive Classifier", label_col="rep_pos")
  print("Making republican negative ROC plot...")
  plot_roc(rep_neg_model, rep_neg_test, "Republican Negative Classifier", label_col="rep_neg")

except:
  print("No parquets loaded, no ROC plot made")
