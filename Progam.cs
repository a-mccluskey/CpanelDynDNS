using System;
using System.IO;
using System.Net;

namespace Test
{
    class Program
    {
        static void Main(string[] args)
        {
            Console.Title = "DNS updater";
            Console.WriteLine("Started at: " + DateTime.UtcNow + " UTC\nChecking every 2 minutes.\nUse Ctrl+C to exit");
            while (true)
            {
                WebClient client = new WebClient();
                client.Headers.Add(HttpRequestHeader.UserAgent, "Site DNS update check");
                Stream stream = client.OpenRead("https://www.SiteDomain.com/updateIP.php");
                StreamReader reader = new StreamReader(stream);
                String content = reader.ReadToEnd();
                if(content.Contains("Addresses match"))
                {
                    //pass
                }
                else
                {
                    Console.WriteLine($"Error at [{DateTime.Now}]: {content}");
                }
                System.Threading.Thread.Sleep(120000);
            }
        }
    }
}
