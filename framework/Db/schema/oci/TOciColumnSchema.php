<?php
/**
 * TOciColumnSchema class file.
 *
 * @author Ricardo Grana <rickgrana@yahoo.com.br>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2009 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

prado::using('System.Db.schema.TDbColumnSchema');

/**
 * TOciColumnSchema class describes the column meta data of a Oracle table.
 *
 * @author Ricardo Grana <rickgrana@yahoo.com.br>
 * @version $Id: TOciColumnSchema.php
 * @package system.db.schema.oci
 * @since 1.0.5
 */
class TOciColumnSchema extends TDbColumnSchema
{
	/**
	 * Extracts the PHP type from DB type.
	 * @param string DB type
	 */
	protected function extractOraType($dbType){
		if(strpos($dbType,'FLOAT')!==false) return 'double';

		if ((strpos($dbType,'NUMBER')!==false) or
			(strpos($dbType,'INTEGER')!==false))
		{
			if(strpos($dbType,'(') && preg_match('/\((.*)\)/',$dbType,$matches))
			{
				$values=explode(',',$matches[1]);
				if(isset($values[1]) and (((int)$values[1]) > 0))
					return 'double';
				else return 'integer';
			}
		}else{
			return 'string';
		}
	}
	protected function extractType($dbType)
	{
		$this->type=$this->extractOraType($dbType);
	}

	protected function extractDefault($defaultValue)
	{
		if(strpos($dbType,'timestamp')!==false)
			$this->defaultValue=null;
		else
			parent::extractDefault($defaultValue);
	}
}
