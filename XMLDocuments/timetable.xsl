<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output method="html" omit-xml-declaration="yes" />

  <!-- Start at the document element -->
  <xsl:template match="schedules">
    <html>
      <head>
        <title>High Street Gym Timetable</title>
        <style>
          body{font-family:system-ui,Arial,sans-serif;margin:24px}
          h1{margin:0 0 12px}
          table{border-collapse:collapse}
          th,td{border:1px solid #000;padding:6px 10px;text-align:left}
          th{background:#f2f2f2}
        </style>
      </head>
      <body>
        <h1>Class Timetable</h1>
        <table>
          <tr>
            <th>Trainer ID</th><th>Class ID</th><th>Day</th>
            <th>Start</th><th>End</th><th>Capacity</th>
          </tr>
          <xsl:for-each select="schedule">
            <tr>
              <td><xsl:value-of select="trainer_id"/></td>
              <td><xsl:value-of select="class_id"/></td>
              <td><xsl:value-of select="day_of_week"/></td>
              <td><xsl:value-of select="start_time"/></td>
              <td><xsl:value-of select="end_time"/></td>
              <td><xsl:value-of select="max_capacity"/></td>
            </tr>
          </xsl:for-each>
        </table>
      </body>
    </html>
  </xsl:template>

  <!-- Fallback: if the template above didn't match, route from root -->
  <xsl:template match="/">
    <xsl:apply-templates select="/schedules"/>
  </xsl:template>
</xsl:stylesheet>
