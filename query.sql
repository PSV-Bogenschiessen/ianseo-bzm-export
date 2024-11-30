SELECT  
  e.EnFirstName as Name,
  e.EnName as Vorname,
  "Frank, Thomas" as Melder, -- "$Submitter"
  co.CoName as Verein,
  "203021" as "Vereinsnr.", -- "$ClubId"
  "BY" as Land, -- "$State"
  e.EnCode as PassNummer,
  q.QuScore as "Ergeb. VM",
  CASE
    WHEN e.EnSex = 0 THEN 'm'
    WHEN e.EnSex = 1 THEN 'w'
    ELSE e.EnSex
  END AS "m/w",
  CASE
    WHEN e.EnDivision = 'R' THEN 'rec'
    WHEN e.EnDivision = 'B' THEN 'blank'
    WHEN e.EnDivision = 'C' THEN 'comp'
    ELSE e.EnDivision
  END AS Bogenart,
  DAY(e.EnDob) AS "Geb. Tag",
  MONTH(e.EnDob) AS "Geb. Monat",
  YEAR(e.EnDob) AS "Jahrg.",
  SUBSTRING(e.EnClass FROM 2) AS "Klasse Nr.",
  "" AS "Änd. Klasse",
  "" AS "Startnr.",
  "" AS "Zähler",
  "" AS "Start- geld",
  "" AS "Mannsch. Nummer",
  CONCAT(e.EnFirstName, ', ', e.EnName) AS NameT,
  "BZMWA7202016" AS "Veranstaltungstitel",
  "ja" AS "Meldung Schütze",
  CONCAT(e.EnDob, "T00:00:00") AS "Geb_datumT"
FROM ianseo.Entries e
left join Qualifications q on e.EnId = q.QuId
left join Countries co on (e.EnTournament = co.CoTournament and e.EnCountry = co.CoId)
where e.EnTournament = 140 -- $TourId
and q.QuScore > 0
ORDER BY CAST(SUBSTRING(e.EnClass FROM 2) AS UNSIGNED), q.QuScore DESC
