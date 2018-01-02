using System;
using System.Collections.Generic;
using System.Text;

namespace MasteryLevelCalculator
{
    class MasteryCore
    {
        private DateTime baseTime;
        private double[] mastaryIndex = new double[] { 1, 3.3, 4, 5 };

        public MasteryCore()
        {
            this.baseTime = DateTime.Now;
        }

        public List<LearningList> createLearningList(List<Learned> learnedList)
        {
            var learningLists = new List<LearningList>();

            for (int i = 0; i < learnedList.Count; i++)
            {
                LearningList learningList = new LearningList();

                learningList.m_page_id = learnedList[i].m_page_id;
                learningList.t_learninglist_memorystrength = getMemoryStrength(learnedList[i].m_learned_masterylevel, learnedList[i].m_learned_datetime);

                if(learningList.t_learninglist_memorystrength<1)learningLists.Add(learningList);
            }

            int intmax = 2147483647;
            learningLists.Sort((a, b) => (int)(a.t_learninglist_memorystrength * intmax) - (int)(b.t_learninglist_memorystrength * intmax));

            return learningLists;
        }

        private double getMemoryStrength(int MastaryLevel, DateTime LearningDate)
        {

            double k = mastaryIndex[MastaryLevel] * 15.297;
            double t = this.baseTime.Subtract(LearningDate).TotalMinutes;

            double dRandom = new Random().NextDouble()*0.2+0.9;

            return k / Math.Pow(Math.Log10(t / 0.0001224), 2) * dRandom;

        }
    }
}
