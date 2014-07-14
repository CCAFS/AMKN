<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:fn="http://www.w3.org/2005/xpath-functions" xmlns:media="http://search.yahoo.com/mrss/"
	    xmlns:dc="http://purl.org/dc/elements/1.1/"
	    xmlns:creativeCommons="http://cyber.law.harvard.edu/rss/creativeCommonsRssModule.html"
	          xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#"
      xmlns:georss="http://www.georss.org/georss"
      xmlns:woe="http://where.yahooapis.com/v1/schema.rng"
	    xmlns:flickr="urn:flickr:">
	<xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes" cdata-section-elements="text"/>
	<xsl:strip-space elements="*"/>
	<!--
http://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=f05f77c6bfc606570ba3053bfc9d590b&user_id=55227776@N04

http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=f05f77c6bfc606570ba3053bfc9d590b&user_id=55227776@N04&photoset_id=72157625593366386&extras=license,%20date_upload,%20date_taken,%20owner_name,%20icon_server,%20original_format,%20last_update,%20geo,%20tags,%20machine_tags,%20o_dims,%20views,%20media,%20path_alias,%20url_sq,%20url_t,%20url_s,%20url_m,%20url_o

TESTING FLICKR
-->
	<xsl:param name="api_key"/>
	<xsl:param name="user_id"/>
	<xsl:template match="*">
<rss version="2.0"
	    xmlns:media="http://search.yahoo.com/mrss/"
	    xmlns:dc="http://purl.org/dc/elements/1.1/"
	    xmlns:creativeCommons="http://cyber.law.harvard.edu/rss/creativeCommonsRssModule.html"
	          xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#"
      xmlns:georss="http://www.georss.org/georss"
      xmlns:woe="http://where.yahooapis.com/v1/schema.rng"
	    xmlns:flickr="urn:flickr:" >
	<channel>






	
		<xsl:variable name="photoset" select="document('http://api.flickr.com/services/rest/?method=flickr.photosets.getList&amp;api_key=',$api_key,'&amp;user_id=',$user_id)"/>
		<xsl:for-each select="$photoset/rsp/photosets/photoset">
		<xsl:variable name="setID" select="@id" />
		<xsl:variable name="setTitle" select="title" />
		<xsl:variable name="setDesc" select="description" />
		<xsl:variable name="photos" select="document('http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&amp;api_key=', $api_key, '&amp;user_id=', $user_id, '&amp;photoset_id=', $setID, '&amp;extras=license,%20date_upload,%20date_taken,%20owner_name,%20icon_server,%20original_format,%20last_update,%20geo,%20tags,%20machine_tags,%20o_dims,%20views,%20media,%20path_alias,%20url_sq,%20url_t,%20url_s,%20url_m,%20url_o')"/>
		
<xsl:if test="position() = 1">
		<title><xsl:value-of select="$setTitle" /></title>
		<link>http://www.flickr.com/photos/55227776@N04/tags/amkn/</link>
 		<description><xsl:value-of select="$setDesc" /></description>
		<pubDate>Mon, 29 Nov 2010 05:04:14 -0800</pubDate>

		<lastBuildDate>Mon, 29 Nov 2010 05:04:14 -0800</lastBuildDate>
		<generator>http://trabaria.com/</generator>
		<image>
			<url>http://farm5.static.flickr.com/4106/buddyicons/55227776@N04.jpg?1291219927#55227776@N04</url>
			<title>CCAFS AMKN PhotoSets</title>
			<link>http://www.flickr.com/photos/55227776@N04/tags/amkn/</link>
		</image>
</xsl:if>		
		
		<item>
			<title><xsl:value-of select="title" /></title>
			<link><xsl:value-of select="concat('http://www.flickr.com/photos/', $user_id, '/sets/', $setID, '/')" /></link>
			<description>			&lt;p&gt;
			&lt;a href=&quot;<xsl:value-of select="concat('http://www.flickr.com/photos/', $user_id, '/sets/', $setID, '/')" />&quot;&gt;<xsl:value-of select="title" />&lt;/a&gt;
			&lt;/p&gt;

</description>
			<pubDate>Mon, 29 Nov 2010 05:04:14 -0800</pubDate>
			                        <dc:date.Taken>2010-11-16T16:25:32-08:00</dc:date.Taken>
            			<author flickr:profile="http://www.flickr.com/people/55227776@N04/">nobody@flickr.com (CCAFS)</author>

			<guid isPermaLink="false">tag:flickr.com,2004:/photo/5217865388</guid>
                <georss:point>14.003367 -2.37854</georss:point>
    <geo:lat>14.003367</geo:lat>
    <geo:long>-2.37854</geo:long>
    <woe:woeid>55967632</woe:woeid>
                <media:content url="http://farm6.static.flickr.com/5004/5217865388_58b621659c_o.jpg" 
                   type="image/jpeg"
                   height="2136"
                   width="3216"/>

    <media:title>Ninigui Village - Yatenga (Burkina Faso)</media:title>
    <media:description type="html">
    
    &lt;p&gt;
	<xsl:for-each select="$photos/rsp/photoset/photo">
	
	
	
	</xsl:for-each>		

    &lt;/p&gt;</media:description>
    <media:thumbnail url="http://farm6.static.flickr.com/5004/5217865388_223629e09f_s.jpg" height="75" width="75" />
    <media:credit role="photographer">CCAFS</media:credit>

    <media:category scheme="urn:flickr:tags">amkn</media:category>
		<creativeCommons:license>http://creativecommons.org/licenses/by-nc-sa/2.0/deed.en</creativeCommons:license>
		</item>
		
				



		</xsl:for-each>		
	</channel>
</rss>		
		
		
		
		
		
		
		
		
		
		
		
		
		

	</xsl:template>
	
	<xsl:template name="getHead">
	
		<xsl:param name="sID"/>
		<xsl:param name="pts"/>
		<xsl:param name="ttl"/>
		
  <xsl:for-each select="$pts/rsp/photoset/photo">
  <xsl:sort select="lastupdate" data-type="number"/>
    <xsl:if test="position() = 1">
		<title>CCAFS AMKN PhotoSets</title>
		<link>http://www.flickr.com/photos/55227776@N04/tags/amkn/</link>
 		<description></description>
		<pubDate>Mon, 29 Nov 2010 05:04:14 -0800</pubDate>

		<lastBuildDate>Mon, 29 Nov 2010 05:04:14 -0800</lastBuildDate>
		<generator>http://trabaria.com/</generator>
		<image>
			<url>http://farm5.static.flickr.com/4106/buddyicons/55227776@N04.jpg?1291219927#55227776@N04</url>
			<title>CCAFS AMKN PhotoSets</title>
			<link>http://www.flickr.com/photos/55227776@N04/tags/amkn/</link>
		</image>


    </xsl:if>


  </xsl:for-each>
	
	
	

</xsl:template>
</xsl:stylesheet>
