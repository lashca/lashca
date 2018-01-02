using System;
using System.Collections.Generic;
using System.Text;
using System.Diagnostics;
using System.IO;

namespace MasteryLevelCalculator
{
    class MasteryIF
    {

        static string inputDir = Directory.GetCurrentDirectory() + "/data/input/";
        static string outputDir = Directory.GetCurrentDirectory() + "/data/output/";

        private static List<List<string>> readCSV(String fileName)
        {
            String inputFile = inputDir + fileName;
            var CSVstring = new List<List<string>>();
            try
            {
                using (var sr = new StreamReader(inputFile))
                {
                    while (!sr.EndOfStream)
                    {
                        var CSVline = new List<string>();
                        var line = sr.ReadLine();
                        var values = line.Split(',');
                        foreach (var value in values)
                        {
                            var splitvalue = value.Split('"');
                            if(splitvalue.Length > 1) CSVline.Add(splitvalue[1]);
                            else CSVline.Add(value);
                        }
                        CSVstring.Add(CSVline);
                    }
                }
            }
            catch (Exception e)
            {
                Debug.WriteLine(e.Message);
                Console.WriteLine(e.Message);
            }
            
            return CSVstring;
        }

        private static void writeCSV(String fileName, List<List<string>> CSVstring)
        {
            String inputFile = inputDir + fileName;
            String outputFile = outputDir + fileName;

            try
            {
                var sw = new StreamWriter(outputFile);
                foreach (List<string> line in CSVstring)
                {
                    foreach(string value in line)
                    {
                        sw.Write(value + ",");
                    }
                    sw.Write("\r\n");
                }
                sw.Close();

                File.Delete(inputFile);
            }
            catch (Exception e)
            {
                Debug.WriteLine(e.Message);
                Console.WriteLine(e.Message);
            }
        }

        private static List<Learned> readLearnedCSV(List<List<string>> CSVstring)
        {
            var learnedList = new List<Learned>();
            for (int i = 0; i < CSVstring.Count; i++)
            {
                var learned = new Learned();

                learned.m_page_id = int.Parse(CSVstring[i][0]);
                if (CSVstring[i][1] == "0000-01-01 00:00:00") CSVstring[i][1] = "0001-01-01 00:00:00";
                learned.m_learned_datetime = DateTime.ParseExact(CSVstring[i][1], "yyyy-MM-dd HH:mm:ss", null);
                learned.m_learned_correctedcount = int.Parse(CSVstring[i][2]);
                learned.m_learned_masterylevel = int.Parse(CSVstring[i][3]);
                learnedList.Add(learned);
            }
            return learnedList;
        }

        private static List<List<string>> writeLearnedCSV(List<LearningList> learningLists)
        {
            var CSVstring = new List<List<string>>();

            for (int i = 0; i < learningLists.Count; i++)
            {
                var CSVline = new List<string>();
                CSVline.Add(learningLists[i].m_page_id.ToString());
                CSVline.Add(learningLists[i].t_learninglist_memorystrength.ToString());

                CSVstring.Add(CSVline);
            }

            return CSVstring;
        }

        public static void Main(string[] args)
        {
            String fileName = "Learned_1_3_2018-01-02-233054.csv";
            int inputType = 0;

            if (args.Length == 1) fileName = args[0];

            if (fileName.Split('_')[0]== "Learned") inputType = 0;
            else if((fileName.Split('_')[0] == "LearningList")) inputType = 1;

            if (inputType == 0)
            {
                List<Learned> learnedList = readLearnedCSV(readCSV(fileName));
                MasteryCore mc = new MasteryCore();
                List<LearningList> learningLists = mc.createLearningList(learnedList);

                writeCSV(fileName, writeLearnedCSV(learningLists));
            }
            
        }
    }
}
