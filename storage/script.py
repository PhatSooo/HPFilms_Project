import pickle
import numpy as np
import sys
import json
from sklearn.metrics.pairwise import cosine_similarity


pickle_in = open(r"D:\xampp\htdocs\HPFilms\storage\model.pkl",'rb')
(cosine_sim,indices,count,id,soup) = pickle.load(pickle_in)


def get_recommendations(cosine_sim,movie_id=None):
  #Index of the movie that matches the title
  if (movie_id is not None):
    idx = indices[movie_id]
  else: idx = -1

  #Pairwise similarity scores of all movies with that movie
  sim_scores = list(enumerate(cosine_sim[idx]))

  #Sorting the movies based on the similarity movie
  sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)

  #Scores of the 1000 most similar movies
  sim_scores = sim_scores[1:10]

  #Get the movie index
  movie_indices = [i[0] for i in sim_scores]

  #Return the top 10 most similar movies
  return id.iloc[movie_indices]


def new_cosine(cos,new_vector):
  new_row = cosine_similarity(new_vector, count.fit_transform(soup))[0]

  # Add new row to bottom of cosine similarity matrix
  cosine_sim2 = np.vstack([cos, new_row])

  # Add new column to right of cosine similarity matrix
  new_column = np.append(new_row, [1])
  cosine_sim2 = np.column_stack([cosine_sim2, new_column])

  return get_recommendations(cosine_sim2)


if (int(sys.argv[1]) in id.tolist()):
    print(get_recommendations(cosine_sim,int(sys.argv[1])).tolist())
else:
    new_vector = json.loads(sys.argv[2])
    new_vector = count.transform(new_vector)
    print(new_cosine(cosine_sim,new_vector).tolist())
